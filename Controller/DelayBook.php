<?php
require_once "../Model/DelayActions.php";
require_once "../Model/UserActions.php";
require_once "../Model/LostActions.php";
$delay_book_id = $_POST["bookID"];
$delay_username = $_POST["username"];
$delay_additional_days = $_POST["additional_days"];
$reason_of_delay = $_POST["reason_of_delay"];
$user_id = FindUserByUsername($delay_username)["id"];
$user_book_id = FindUserBookID($delay_book_id, $user_id);
$exec_res = InsertIntoDelayApplication($user_book_id, $delay_additional_days, $reason_of_delay);
print_r($exec_res);