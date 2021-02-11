<?php
require_once "../Model/UserActions.php";
require_once "../Model/BorrowAppActions.php";
require_once "../Model/DelayActions.php";
require_once "../Model/UserAppActions.php";
session_start();
if (isset($_POST["userapp"])) {
    if ($_POST["userapp"] == 1) {
        if ($_POST['approve'] == 1) {
            CreatingNewUser($_POST['username'], $_SESSION['id']);
        } else {
            RejectRegApplication($_POST['username'], $_SESSION['id']);
        }
    }
}

if (isset($_POST["borrowapp"])) {
    $borrow_app_id = $_POST['borrow_app_id'];
    $updater_username = $_SESSION['username'];
    $book_id = $_POST['book_id'];
    $isApprove = $_POST['approve'];
    if ($_POST["borrowapp"] == 1) {
        if ($isApprove == 1) {
            $borrowing_user_id = $_POST["borrowing_user_id"];
            $days_of_borrow = $_POST["days_of_borrow"];
            ApprovingBorrowApplication($borrow_app_id, $updater_username, 1, $book_id, $borrowing_user_id, $days_of_borrow, 1);
        } else if ($isApprove == 0) {
            RejectingBorrowApplication($borrow_app_id, $updater_username, 0);
        }
    }
}

if (isset($_POST["delayapp"])) {
    $delay_app_id = $_POST["delay_app_id"];
    $updater_username = $_SESSION['username'];
    $isApprove = $_POST["approve"];
    if ($isApprove == 1) {
        $exec_res = UpdateDelayApplication($delay_app_id, $updater_username, 1);
    } else if ($isApprove == 0) {
        $exec_res = UpdateDelayApplication($delay_app_id, $updater_username, 2);
    }

    if ($exec_res == 1) {
        echo "Successfully updated delay application";
    }
}



