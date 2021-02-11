<?php
require_once "../Model/UserActions.php";
session_start();
$username = $_SESSION["username"];
$password = $_POST["password"];
$orig_info = FetchingPersonalInfo($username, $password);

if (!isset($_POST["first_name"])) {
    $first_name = $orig_info[0];
} else {
    $first_name = $_POST["first_name"];
}

if (!isset($_POST["last_name"])) {
    $last_name = $orig_info[1];
} else {
    $last_name = $_POST["last_name"];
}

if (!isset($_POST["gender"])) {
    $gender = $orig_info[2];
} else {
    $gender = $_POST["gender"];
}

if (!isset($_POST["age"])) {
    $age = $orig_info[3];
} else {
    $age = $_POST["age"];
}

$usr_auth = UserAuthentication($username, $password);
if ($usr_auth) {
    UpdatePersonalInfo($first_name, $last_name, $gender, $age, $username);
} else {
    echo "Wrong password or username, ";
    echo "<a href='../Controller/ChangePersonalInfo.php'>Back to change personal information page</a>";
}




