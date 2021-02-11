<?php
require_once "../Model/logincredentials.php";
require_once "../Model/UserActions.php";
require_once "../Model/LostActions.php";
$lost_book_id = $_POST["lost_book_id"];
$lost_user_name = $_POST["lost_username"];
$lost_user_id = FindUserByUsername($lost_user_name)[0];
$lost_book_price = $_POST["lost_book_price"];
$lost_reason = $_POST["lost_reason"];
$user_book_id = FindUserBookID($lost_book_id, $lost_user_id);
$exec_res1 = InsertIntoLossApplication($user_book_id, $lost_reason, $lost_book_price);
$exec_res2 = UpdateBook($lost_book_id, 2);
$exec_res3 = UpdateUserBooksTable($lost_user_id, $lost_book_id, 3);
if ($exec_res1 == 1 & $exec_res2 == 1 && $exec_res3 == 1) {
    echo "book successfully updated!";
}