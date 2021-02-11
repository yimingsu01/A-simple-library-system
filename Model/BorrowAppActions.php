<?php
require_once 'UserActions.php';
require_once 'logincredentials.php';
function ApprovingBorrowApplication($borrow_app_id, $updater_username, $audit_res, $book_id, $borrowing_user_id, $days_of_borrow, $borrowing_status) {
 // UpdateBorrowApplication
    // UpdateBook
    // InsertUserBooksTable
    $exec_res1 = UpdateBorrowApplication($borrow_app_id, $updater_username, $audit_res);
    $exec_res2 = UpdateBook($book_id, 1);
    $exec_res3 = InsertUserBooksTable($book_id, $borrowing_user_id, $days_of_borrow, $borrowing_status);
    //-- 0 - returned, 1 - borrowing, 2 - lost the book
    //-- in user_book.status
    //
    //-- 0 - no overtime, 1 - overtimed
    //-- in user_book.overtime
    //
    //-- 0 - Not approved, 1 - Approved, 2 - Book returned.
    //-- in borrow_application.borrow_status.
    if ($exec_res1 == 1 && $exec_res2 == 1) {
        if ($exec_res3 == 1) {
            echo "Successfully approved borrow application id: " . $borrow_app_id;
        }
    }
}

function RejectingBorrowApplication($borrow_app_id, $updater_username, $audit_res) {
    // UpdateBorrowApplication
    UpdateBorrowApplication($borrow_app_id, $updater_username, $audit_res);
}
