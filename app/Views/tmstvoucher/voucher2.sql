CREATE PROCEDURE InsertVoucherHeaderAndDetail
    @TransactionID VARCHAR(20),
    @Description NVARCHAR(100),
    @TotalVoucher INT,
    @Applicable VARCHAR(50),
    @TotalAmount MONEY,
    @ExpiredDate DATE,
    @CreatedBy VARCHAR(10),
    @Remarks1 NVARCHAR(100),
    @Remarks2 NVARCHAR(100)
AS
BEGIN
    SET NOCOUNT ON;

    -- Insert Header (status belum approved)
    INSERT INTO VoucherHeader (
        [Transaction ID], [Description], [Total Voucher],
        [Applicable], [Total Amount], [Expired Date],
        [Status], [Created By], [Date Created],
        [Remarks 1], [Remarks 2]
    )
    VALUES (
        @TransactionID, @Description, @TotalVoucher,
        @Applicable, @TotalAmount, @ExpiredDate,
        'Pending', @CreatedBy, GETDATE(),
        @Remarks1, @Remarks2
    );

    -- Insert Detail
    DECLARE @Counter INT = 1;
    DECLARE @SerialBase VARCHAR(10) = LEFT(@TransactionID, 7);
    DECLARE @SerialNo VARCHAR(20);
    DECLARE @AmountPerVoucher MONEY = @TotalAmount / @TotalVoucher;

    WHILE @Counter <= @TotalVoucher
    BEGIN
        SET @SerialNo = @SerialBase + RIGHT('000' + CAST(@Counter AS VARCHAR), 3);

        INSERT INTO VoucherDetail (
            [Transaction ID], [Line], [Serial No], [Amount]
        )
        VALUES (
            @TransactionID, @Counter, @SerialNo, @AmountPerVoucher
        );

        SET @Counter += 1;
    END
END;