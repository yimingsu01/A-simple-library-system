<?php
require_once "../Model/UserActions.php";
session_start();
$username = $_SESSION["username"];
$password = $_POST["password"];
$orig_sq_a = explode(",", FetchingSQandA($username, $password)[1]);

if (!isset($_POST["sq1a"])) {
    $sq1a = $orig_sq_a[0];
} else if (isset($_POST["sq1a"])) {
    $sq1a = $_POST["sq1a"];
}

if (!isset($_POST["sq2a"])) {
    $sq2a = $orig_sq_a[1];
} else if (isset($_POST["sq2a"])) {
    $sq2a = $_POST["sq2a"];
}

if (!isset($_POST["sq3a"])) {
    $sq3a = $orig_sq_a[2];
} else if (isset($_POST["sq3a"])) {
    $sq3a = $_POST["sq3a"];
}

$sq1 = $_POST["sq1"];
$sq2 = $_POST["sq2"];
$sq3 = $_POST["sq3"];

$sq = $sq1 . "," . $sq2 . "," . $sq3;
$sqa = $sq1a . "," . $sq2a . "," . $sq3a;

$usr_auth = UserAuthentication($username, $password);
if ($usr_auth) {
    ChangeSQ($username, $password, $sq, $sqa);
} else {
    echo "Wrong password or username, ";
    echo "<a href='../Controller/ChangeSQ.php'>Back to change safe questions page</a>";
}
