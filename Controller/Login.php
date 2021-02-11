<?php
require_once '../Model/UserActions.php';
require_once '../Model/logincredentials.php';
$conn = createconn();
session_start();
//echo $_POST['username'];
//echo $_POST['password'];
if (isset($_POST['username']) &&
    isset($_POST['password'])) {
    $username = get_post($conn, 'username');
    $password = get_post($conn, 'password');
    $login_result = UserAuthentication($username, $password);
//    print_r($login_result);
    $isAdmin = AdminAuthentication($username, $password);
    if ($login_result != false && !(isset($_SESSION['username']))) {
//        setcookie('username', $username, time() + 3600, '/');
        $_SESSION['username'] = $username;
        $_SESSION['login'] = "true";
        $_SESSION['id'] = FindUserByUsername($username)["id"];
        echo "logged in, welcome, " . $username;
        echo "<br>";
        echo "<a href='../dashboard.php'>continue to dashboard</a>";
        if ($isAdmin == "true") {
            $_SESSION['admin'] = "true";
            echo "<br>";
            echo "<a href='admin-audit.php'> continue to admin </a>";
        } else {
            $_SESSION['admin'] = "false";
        }
    } else if ($login_result != false && $_SESSION['username'] == $username ) {
        echo "you have already logged in";
        echo "<br>";
        echo "<a href='../dashboard.php'> continue to dashboard</a>";
        if ($_SESSION['admin'] == 'true') {
            echo "<br>";
            echo "<a href='admin-audit.php'> continue to admin </a>";
        }
    } else if ($login_result == false) {
        echo "wrong username or password";
        echo "<br> <a href='../index.php'>Back to Login</a>";
    }
}


