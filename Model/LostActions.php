<?php
require_once "logincredentials.php";
function InsertIntoLossApplication($user_book_id, $reason_of_loss, $book_price) {
    $conn = createconn();
    $query = "insert into loss_application (user_book_id, create_time, reasons_of_loss, book_price) value (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("issd", $stmt_user_book_id, $stmt_create_time, $stmt_reasons_of_loss, $stmt_book_price);
    $stmt_user_book_id = $user_book_id;
    $stmt_create_time = date("Y-m-d");
    $stmt_reasons_of_loss = $reason_of_loss;
    $stmt_book_price = $book_price;
    $stmt->execute();
    $affected_rows = $stmt->affected_rows;
    $stmt->close();
    $conn->close();
    return $affected_rows;
}

function FindUserBookID($book_id, $user_id) {
    $conn = createconn();
    $query = "select * from user_books where book_id=? and user_id=? and status=1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $stmt_book_id, $stmt_user_id);
    $stmt_book_id = $book_id;
    $stmt_user_id = $user_id;
    $stmt->execute();
    $res = $stmt->get_result()->fetch_array();
    return $res[0];
}



