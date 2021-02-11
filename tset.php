<?php
require_once "functions.php";
require_once "Model/logincredentials.php";
//selectAllFromTable($db_hostname, $db_username, $db_password, $db_database, "classics");
//$conn = createconn();
//$query = 'select * from user where username="yimingsu"';
//$stmt = $conn->prepare($query);
//$stmt->execute();
//$results = $stmt->get_result();
//print_r($results->fetch_all());

//session_start();
//if (isset($_SESSION["id"])) {
//    echo "welcome," . $_SESSION["id"];
//} else {
//    if (isset($_GET['id'])) {
//        $_SESSION["id"] = $_GET['id'];
//    } else {
//        echo "no user.";
//    }
//}

//$value = "1234";
//setcookie('id', $value, time() + 10);

if (isset($_COOKIE['id'])) {
    echo "welcome," . $_COOKIE['id'];
} else {
    if (isset($_GET['id'])) {
//        $_SESSION["id"] = $_GET['id'];
        setcookie('id', $_GET['id'], time() + 10);
    } else {
        echo "no user.";
    }
}
