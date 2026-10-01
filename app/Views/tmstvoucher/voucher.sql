ALTER PROCEDURE InsertVoucherData @TransactionID VARCHAR(20)
	,@Description NVARCHAR(100)
	,@TotalVoucher INT
	,@Applicable VARCHAR(50)
	,@TotalAmount MONEY
	,@ExpiredDate DATE
	,@CreatedBy VARCHAR(10)
	,@ApprovedBy VARCHAR(10)
	,@Remarks1 NVARCHAR(100)
	,@Remarks2 NVARCHAR(100)
AS
BEGIN
	SET NOCOUNT ON;

	BEGIN TRY
		BEGIN TRANSACTION;

		-- 1️⃣ Insert Header
		INSERT INTO VoucherHeader (
			[VoucherID]
			,[Description]
			,[TotalVoucher]
			,[Applicable]
			,[TotalAmount]
			,[ExpiredDate]
			,[Status]
			,[CreatedBy]
			,[DateCreated]
			,[ApprovedBy]
			,[DateApproved]
			,[Remarks1]
			,[Remarks2]
			)
		VALUES (
			@TransactionID
			,@Description
			,@TotalVoucher
			,@Applicable
			,@TotalAmount
			,@ExpiredDate
			,'Approved'
			,@CreatedBy
			,GETDATE()
			,@ApprovedBy
			,GETDATE()
			,@Remarks1
			,@Remarks2
			);

		-- 2️⃣ Prepare per voucher values
		DECLARE @Counter INT = 1;
		DECLARE @SerialBase VARCHAR(10) = LEFT(@TransactionID, 7);
		DECLARE @SerialNo VARCHAR(20);
		DECLARE @AmountPerVoucher MONEY = @TotalAmount / @TotalVoucher;

		-- 3️⃣ Insert Detail & History
		WHILE @Counter <= @TotalVoucher
		BEGIN
			SET @SerialNo = @SerialBase + RIGHT('000' + CAST(@Counter AS VARCHAR), 3);

			-- 📋 Detail
			INSERT INTO VoucherDetail (
				[VoucherID]
				,[LineNumber]
				,[SerialNo]
				,[Amount]
				)
			VALUES (
				@TransactionID
				,@Counter
				,@SerialNo
				,@AmountPerVoucher
				);

			-- 🕘 History (Belum Digunakan)
			INSERT INTO VoucherHistory (
				[VoucherID]
				,[LineNumber]
				,[BarcodeID]
				,[Applicable]
				,[Amount]
				,[ExpiredDate]
				,[AlreadyUsed]
				,[Balance]
				,[DateUsed]
				,[RegisterNo]
				,[CreatedBy]
				,[DateCreated]
				,[EditedBy]
				)
			VALUES (
				@TransactionID
				,@Counter
				,@SerialNo
				,@Applicable
				,@AmountPerVoucher
				,@ExpiredDate
				,0
				,@AmountPerVoucher
				,NULL
				,NULL
				,@CreatedBy
				,GETDATE()
				,NULL
				);

			SET @Counter += 1;
		END

		COMMIT TRANSACTION;
	END TRY

	BEGIN CATCH
		ROLLBACK TRANSACTION;

		-- Jika perlu, log error di sini
		THROW;
	END CATCH
END;