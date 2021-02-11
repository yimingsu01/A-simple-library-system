<?php
require_once "logincredentials.php";
function InsertIntoDelayApplication($user_book_id, $additional_days, $reasons_of_delay) {
    $conn = createconn();
    $query = "insert into delay_application (user_books_id, additional_days, reasons_of_delay, create_time) value (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiss", $stmt_user_books_id, $stmt_additional_days, $stmt_reasons_of_delay, $stmt_create_time);
    $stmt_user_books_id = $user_book_id;
    $stmt_additional_days = $additional_days;
    $stmt_reasons_of_delay = $reasons_of_delay;
    $stmt_create_time = date("Y-m-d");
    $stmt->execute();
    $exec_res = $stmt->affected_rows;
    $stmt->close();
    $conn->close();
    return $exec_res;
}

function UpdateDelayApplication($delay_app_id, $updater_username, $audit_res) {
    $conn = createconn();
    $query = "update delay_application set status=?, updater=?, update_time=? where id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iisi", $stmt_status, $stmt_updater, $stmt_update_time, $stmt_id);
    $stmt_status = $audit_res;
    $stmt_id = $delay_app_id;
    $updater_id = FindUserByUsername($updater_username)[0];
    $stmt_updater = $updater_id;
    $stmt_update_time = date("Y-m-d");
    $stmt->execute();
    $exec_res = $stmt->affected_rows;
    $stmt->close();
    $conn->close();
    return $exec_res;
}