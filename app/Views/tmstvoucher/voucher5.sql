ALTER PROCEDURE [dbo].[sp_voucherheader_iud] @action VARCHAR(50)
	,@VoucherID VARCHAR(15)
	,@Description VARCHAR(100)
	,@TotalVoucher INT
	,@Applicable VARCHAR(50)
	,@TotalAmount DECIMAL(18, 2)
	,@ExpiredDate DATE
	,@Status VARCHAR (20)
	,@CreatedBy VARCHAR(10)
	,@ApprovedBy VARCHAR(10)
	,@Remarks1 VARCHAR(255)
	,@Remarks2 VARCHAR(255)
AS
BEGIN
	SET NOCOUNT ON;

    IF @action = 'insert'
    DECLARE @TotalAmount MONEY = @Amount * @TotalVoucher;

	-- Insert Header
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
		,[Remarks1]
		,[Remarks2]
		)
	VALUES (
		@VoucherID
		,@Description
		,@TotalVoucher
		,@Applicable
		,@TotalAmount
		,@ExpiredDate
		,'Pending'
		,@CreatedBy
		,GETDATE()
		,@Remarks1
		,@Remarks2
		);

	-- Insert Detail
	DECLARE @Counter INT = 1;
	DECLARE @KodeDasar VARCHAR(10) = RIGHT(@VoucherID, 7);-- ambil '2507001'
	DECLARE @SerialNo VARCHAR(20);

	WHILE @Counter <= @TotalVoucher
	BEGIN
		SET @SerialNo = @KodeDasar + RIGHT('000' + CAST(@Counter AS VARCHAR), 3);-- hasil: 2507001001 dst

		INSERT INTO VoucherDetail (
			[VoucherID]
			,[LineNumber]
			,[SerialNo]
			,[Amount]
			)
		VALUES (
			@VoucherID
			,@Counter
			,@SerialNo
			,@Amount
			);

		SET @Counter += 1;
	END
    END

	IF @action = 'insert'
	BEGIN
		INSERT INTO VoucherHeader (
			VoucherID
			,Description
			,TotalVoucher
			,Applicable
			,TotalAmount
			,ExpiredDate
			,STATUS
			,CreatedBy
			,DateCreated
			,ApprovedBy
			,DateApproved
			,Remarks1
			,Remarks2
			)
		VALUES (
			@VoucherID
			,@Description
			,@TotalVoucher
			,@Applicable
			,@TotalAmount
			,@ExpiredDate
			,@Status
			,@CreatedBy
			,GETDATE()
			,@ApprovedBy
			,GETDATE()
			,@Remarks1
			,@Remarks2
			);
	END

	IF @action = 'update'
	BEGIN
		UPDATE VoucherHeader
		SET Description = @Descripti ON
			,TotalVoucher = @TotalVoucher
			,Applicable = @Applicable
			,TotalAmount = @TotalAmount
			,ExpiredDate = @ExpiredDate
			,STATUS = @Status
			,ApprovedBy = @ApprovedBy
			,DateApproved = GETDATE()
			,Remarks1 = @Remarks1
			,Remarks2 = @Remarks2
		WHERE VoucherID = @VoucherID;
	END

	IF @action = 'delete'
	BEGIN
		DELETE
		FROM VoucherHeader
		WHERE VoucherID = @VoucherID;
	END
END