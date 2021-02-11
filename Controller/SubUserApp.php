<?php
require_once '../Model/UserActions.php';
require_once '../Model/logincredentials.php';
$conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
if (isset($_GET['username']) &&
    isset($_GET['password']) &&
    isset($_GET['first_name']) &&
    isset($_GET['last_name']) &&
    isset($_GET['gender']) &&
    isset($_GET['age']) &&
    isset($_GET['sq1']) &&
    isset($_GET['sq1a']) &&
    isset($_GET['sq2']) &&
    isset($_GET['sq2a']) &&
    isset($_GET['sq3']) &&
    isset($_GET['sq3a']))   {
    $username = get_get($conn, 'username');
    $password = get_get($conn, 'password');
    $first_name = get_get($conn, 'first_name');
    $last_name = get_get($conn, 'last_name');
    $gender = get_get($conn, 'gender');
    $age = get_get($conn, 'age');
    $sq1 = get_get($conn, 'sq1');
    $sq1a = get_get($conn, 'sq1a');
    $sq2 = get_get($conn, 'sq2');
    $sq2a = get_get($conn, 'sq2a');
    $sq3 = get_get($conn, 'sq3');
    $sq3a = get_get($conn, 'sq3a');
    $sq = $sq1 . "," . $sq2 . "," . $sq3;
    $sqa = $sq1a . "," . $sq2a . "," . $sq3a;
    $create_time = date('Y-m-d');
    $isExisted = CheckIfUserExistedRID($username)[0];
    if ($isExisted) {
        echo "Username existed.";
    } else {
        submitUserApplication($username, $first_name, $last_name, $gender, $age, $password, $sq, $sqa, $create_time);
    }
}


function submitUserApplication($username, $first_name, $last_name, $gender, $age, $password, $sq, $sqa, $create_time) {
    $result = InsertIntoUserApplicationTable($username, $first_name, $last_name, $gender, $age, $password, $sq, $sqa, $create_time);
    if ($result) {
        echo "Your application is submitted.";
    } else {
        echo "unexpected error happened.";
    }

}

