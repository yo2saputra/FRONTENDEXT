CREATE PROCEDURE ApproveVoucherHeader
    @TransactionID VARCHAR(20),
    @ApprovedBy VARCHAR(10)
AS
BEGIN
    SET NOCOUNT ON;
    BEGIN TRY
        BEGIN TRANSACTION;

        -- ✅ Ubah status di header
        UPDATE VoucherHeader
        SET [Status] = 'Approved',
            [ApprovedBy] = @ApprovedBy,
            [Date Approved] = GETDATE()
        WHERE [TransactionID] = @TransactionID;

        -- 🔄 Ambil detail dan insert history
        INSERT INTO VoucherHistory (
            [TransactionID], [Line], [BarcodeID], [Applicable],
            [Amount], [ExpiredDate], [AlreadyUsed], [Balance],
            [DateUsed], [RegisterNo], [CreatedBy], [DateCreated], [EditedBy]
        )
        SELECT
            VD.[TransactionID],
            VD.[Line],
            VD.[Serial No],
            VH.[Applicable],
            VD.[Amount],
            VH.[Expired Date],
            'No',
            VD.[Amount],
            NULL,
            NULL,
            VH.[CreatedBy],
            GETDATE(),
            NULL
        FROM VoucherDetailVD
        JOIN VoucherHeaderVH ON VH.[TransactionID] = VD.[TransactionID]
        WHERE VD.[TransactionID] = @TransactionID;

        COMMIT TRANSACTION;
    END TRY
    BEGIN CATCH
        ROLLBACK TRANSACTION;
        THROW;
    END CATCH
END;