<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../admin-audit-css.css">
</head>
<body>
<a href='../dashboard.php'>to dashboard</a>
<div id="top-header">
    <ul>
        <li id="userapp" onclick="show(this.id)">User App</li>
        <li id="borrowapp" onclick="show(this.id)">Borrow App</li>
        <li id="delayapp" onclick="show(this.id)">Delay App</li>
    </ul>
</div>
<div id="userinfo">
    <ul>
<?php
require_once "../Model/logincredentials.php";
require_once "../Model/UserActions.php";
session_start();
//echo $_SESSION['username'];
//echo $_SESSION['login'];
if ($_SESSION['login'] == "true" && $_SESSION['admin'] == "true") {
    $updater = $_SESSION['username'];
//    echo "Reg Application: ";
    $allapps = FetchingAllUserApplication();
    $n = 0;
    $isPrinted = False;
    echo "<div id='user-app-box'>";
    while ($n < count($allapps)) {
        $current_row = $allapps[$n];
//        print_r($current_row);
        $id = $current_row[0];
        $username = $current_row[1];
        $first_name = $current_row[2];
        $last_name = $current_row[3];
        $gender = $current_row[4];
        $age = $current_row[5];
        $safe_questions = $current_row[7];
        $safe_questions_answers = $current_row[8];
        $create_time = $current_row[10];
        $isUserExisted = CleaningUserApplication($current_row[1])[0];
        $isRejected = CleaningUserApplication($current_row[1])[1];
        if (!$isRejected && !$isUserExisted) {
            $isPrinted = True;
            echo <<<_END
            <li>ID: $id, username: $username, first name: $first_name, last name: $last_name, gender: $gender, age: $age, safe questions: $safe_questions, submit time: $create_time </li>
            <form action="Admin-Audit-Continue.php" method="post"> 
                <input type="hidden" name="username" value="$username">
                <input type="hidden" name="userapp" value=1>
                <input type="hidden" name="updater" value="$updater">
                <input type="hidden" name="approve" value=1>
                <input type="submit" value="Approve">
            </form>
            
            <form action="Admin-Audit-Continue.php" method="post"> 
                <input type="hidden" name="username" value="$username">
                <input type="hidden" name="userapp" value=1>
                <input type="hidden" name="updater" value="$updater">
                <input type="hidden" name="approve" value=0>
                <br>
                <input type="submit" value="Reject">
            </form>
            <br>
_END;
        }
        $n ++;
    }
    echo "</div>";
    echo "<div id='borrow-app-box' style='display: none;'>";
    $allapps = FetchingAllBorrowApplication();
    $n = 0;
    $isPrinted = False;
    while ($n < count($allapps)) {
        $current_row = $allapps[$n];
        $app_id = $current_row[0];
        $user_id = $current_row[1];
        $book_id = $current_row[2];
        $app_create_time = $current_row[3];
        $days_of_borrow = $current_row[4];
        $updater_user_id = $current_row[5];
        $borrow_status = $current_row[7];
        $isBorrowed = CheckIfBookBorrowed($book_id);
        $book_title = FindBookByID($book_id)[1];
        $username = FindUserByID($user_id)["username"];
        if (!$isBorrowed && ($borrow_status == 3)) {
            $isPrinted = True;
            echo <<<_END
            <li>App ID: $app_id, User borrowing: $username, book name: $book_title, days of borrow: $days_of_borrow  submit time: $app_create_time </li>
            <form action="Admin-Audit-Continue.php" method="post"> 
                <input type="hidden" name="borrowapp" value=1>
                <input type="hidden" name="borrow_app_id" value=$app_id>
                <input type="hidden" name="borrowing_user_id" value=$user_id>
                <input type="hidden" name="days_of_borrow" value=$days_of_borrow>
                <input type="hidden" name="book_id" value=$book_id>
                <input type="hidden" name="updater" value="$updater">
                <input type="hidden" name="approve" value=1>
                <input type="submit" value="Approve">
            </form>
            
            <form action="Admin-Audit-Continue.php" method="post"> 
                <input type="hidden" name="borrowapp" value=1>
                <input type="hidden" name="borrow_app_id" value=$app_id>
                <input type="hidden" name="book_id" value=$book_id>
                <input type="hidden" name="updater" value="$updater">
                <input type="hidden" name="approve" value=0>
                <br>
                <input type="submit" value="Reject">
            </form>
            <br>
_END;
        }
        $n ++;
    }
    echo "</div>";
    $allapps = FetchingAllDelayApplication();

    echo "<div id='delay-app-box'>";
    $n = 0;
    while ($n < count($allapps)) {
        $current_row = $allapps[$n];
//        print_r($current_row);
        $delay_app_id = $current_row[0];
        $user_books_id = $current_row[1];
        $additional_days = $current_row[2];
        $reasons_of_delay = $current_row[3];
        $create_time = date("Y-m-d");
        $delay_app_status = $current_row[7];

        $user_id = FindUserIDByUserBookID($user_books_id)[2];
        $username = FindUserByID($user_id)["username"];
        $book_id = FindUserIDByUserBookID($user_books_id)[1];
        $book_title = FindBookByID($book_id)["book_name"];
        $n ++;
        if ($delay_app_status == 0) {
            echo <<<_END
<li>App ID: $delay_app_id, User delaying: $username, book name: $book_title, reason of delay: $reasons_of_delay, submit time: $create_time </li>
            <form action="Admin-Audit-Continue.php" method="post"> 
                <input type="hidden" name="delayapp" value=1>
                <input type="hidden" name="delay_app_id" value=$delay_app_id>
                <input type="hidden" name="delay_user_id" value=$user_id>
                <input type="hidden" name="reason_of_delay" value=$reasons_of_delay>
                <input type="hidden" name="book_id" value=$book_id>
                <input type="hidden" name="updater" value="$updater">
                <input type="hidden" name="approve" value=1>
                <input type="submit" value="Approve">
            </form>
            
            <form action="Admin-Audit-Continue.php" method="post"> 
                <input type="hidden" name="delayapp" value=1>
                <input type="hidden" name="delay_app_id" value=$delay_app_id>
                <input type="hidden" name="delay_user_id" value=$user_id>
                <input type="hidden" name="reason_of_delay" value=$reasons_of_delay>
                <input type="hidden" name="book_id" value=$book_id>
                <input type="hidden" name="updater" value="$updater">
                <input type="hidden" name="approve" value=0>
                <br>
                <input type="submit" value="Reject">
            </form>
            <br>
_END;

        }
    }

    echo "</div>";
} else {
    echo "you are not an admin";
}

?>
    </ul>
</div>
<script>
    var userappbox = document.getElementById("user-app-box");
    userappbox.style.display = "none";

    var borrowappbox = document.getElementById("borrow-app-box");
    borrowappbox.style.display = "none";

    var delayappbox = document.getElementById("delay-app-box");
    delayappbox.style.display = "none";

    function show(id) {
        var content_id = ["user-app-box", "borrow-app-box", "delay-app-box"];
        var contentbox = document.getElementById(content_id[0]);
        var otherbox1 = document.getElementById(content_id[0]);
        var otherbox2 = document.getElementById(content_id[0]);
        if (id === "userapp") {
            contentbox = document.getElementById(content_id[0]);
            otherbox1 = document.getElementById(content_id[1]);
            otherbox2 = document.getElementById(content_id[2]);
        } else if (id === "borrowapp") {
            contentbox = document.getElementById(content_id[1]);
            otherbox1 = document.getElementById(content_id[0]);
            otherbox2 = document.getElementById(content_id[2]);
        } else if (id === "delayapp") {
            contentbox = document.getElementById(content_id[2]);
            otherbox1 = document.getElementById(content_id[0]);
            otherbox2 = document.getElementById(content_id[1]);
        }
        // console.log(id);
        // var contentbox = document.getElementById(id);
        if (contentbox.style.display === "none") {
            contentbox.style.display = "block";
            otherbox1.style.display = "none";
            otherbox2.style.display = "none";
        }
    }
</script>
</body>
</html>