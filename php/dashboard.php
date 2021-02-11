<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="dashboard-css.css">
</head>
<body>
<?php
require_once "Model/logincredentials.php";
require_once "Model/UserActions.php";
session_start();
//echo $_SESSION['username'];
//echo $_SESSION['login'];
if (!isset($_SESSION['login'])) {
    echo "You haven't login yet, ";
    echo "<a href='index.php'>Back to login</a>";
} else {
    if ($_SESSION['login'] == "true") {
        $username = $_SESSION['username'];
        $results = FindUserByUsername($username);
        echo <<<_END
    <div id="top">
        <div id="userinfo">
            <p>User ID: <span id="userid">$results[0]</span></p>
            <p>User Type: <span id="usertype">$results[1]</span></p>
            <p>Username: <span id="username">$results[2]</span></p>
            <p>First Name: <span id="firstname">$results[3]</span></p>
            <p>Last Name: <span id="lastname">$results[4]</span></p>
            <p>Gender: <span id="gender">$results[5]</span></p>
            <p>Age: <span id="age">$results[6]</span></p>
            <p>Safe Questions: <span id="safequestion">$results[8]</span></p>
            <p>Safe Question answers: <span id="safequestion">$results[9]</span></p>
            <p>Status: <span id="status">$results[10]</span></p>
            <p>Register Time: <span id="registertime">$results[11]</span></p>
        </div>
        <div id="book_actions">
            <div id="upper_buttons">
                <button><a href="borrow_catalog.php">Borrow a Book</a></button>
                <button><a href="return_catalog.php">Return a Book</a></button>
            </div>
            <div id="lower_buttons">
                <button><a href="loss_catalog.php">Lost a Book?</a></button>
                <button><a href="delay_catalog.php">Wanna Extension?</a></button>
               
            </div>
        </div>
    </div>

    <div id="bottom">
        <br>
        <form action="Controller/LoggingOut.php">
            <input type="submit" value="Quit">
        </form>
        <form action="Controller/ChangePassword.php">
            <input type="submit" value="Change Password">
        </form>
        <form action="Controller/ChangeSQ.php">
            <input type="submit" value="Change Safe Question and Answers">
        </form>
        <form action="Controller/ChangePersonalInfo.php">
            <input type="submit" value="Change Personal Information">
        </form>
        
    </div>
_END;
        if ($_SESSION['admin'] == "true") {
            echo "<a href='Controller/admin-audit.php'>To admin!</a>";
            echo <<<_END
                <form action="Controller/AddBook.php">
                    <input type="submit" value="AddBook">
                </form>
_END;

        }
    }
}





?>
</body>
</html>