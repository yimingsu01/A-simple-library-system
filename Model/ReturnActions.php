<?php
require_once 'UserActions.php';
require_once 'logincredentials.php';
function ReturningBook($book_id, $borrowing_user_id) {
    $conn = createconn();
    $query = "select * from borrow_application where user_id=? and book_id=? and borrow_status=1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $stmt_user_id, $stmt_book_id);
    $stmt_user_id = $borrowing_user_id;
    $stmt_book_id = $book_id;
    $stmt->execute();
    $tot_res = $stmt->get_result()->fetch_all()[0];
    $borrow_app_id = $tot_res[0];
    $exec_res1 = UpdateBorrowApplication($borrow_app_id, "yimingsu", 2);
    $exec_res2 = UpdateBook($book_id, 0);
    $exec_res3 = UpdateUserBooksTable($borrowing_user_id, $book_id, 0);
    print_r($exec_res1);
    print_r($exec_res2);
    print_r($exec_res3);
    $stmt->close();
    $conn->close();
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
            echo "Book successfully returned!";
        }
    }
}

function CheckIfOvertime($book_id, $borrowing_user_id) {
    $conn = createconn();
    $query = "select * from user_books where user_id=? and book_id=? and status=1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $stmt_user_id, $stmt_book_id);
    $stmt_user_id = $borrowing_user_id;
    $stmt_book_id = $book_id;
    $stmt->execute();
    $tot_res = $stmt->get_result()->fetch_all()[0];
    $borrow_start_date = new DateTime($tot_res[5]);
    $borrow_duration = $tot_res[3];
    $current_date = new DateTime(date("Y-m-d"));
    $interval = date_diff($borrow_start_date, $current_date)->days;

    if ($interval > $borrow_duration) {
        $overtime_duration = $interval - $borrow_duration;
        $overtime_price = $overtime_duration * 1.5;
        $query = "update user_books set overtime=?, overtime_price=? where user_id=? and book_id=? and status=1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("idii", $stmt_overtime, $stmt_overtime_price, $stmt_user_id, $stmt_book_id);
        $stmt_user_id = $borrowing_user_id;
        $stmt_book_id = $book_id;
        $stmt_overtime = 1;
        $stmt_overtime_price = $overtime_price;
        $stmt->execute();
        $stmt->close();
        $conn->close();
        return [True, $overtime_price];
    } else {
        $stmt->close();
        $conn->close();
        return [False, 0];
    }


}