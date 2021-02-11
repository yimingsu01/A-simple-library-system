<?php
require_once "../Model/logincredentials.php";
require_once "../Model/UserActions.php";
if (isset($_POST['daysofborrow']) &&
    isset($_POST['bookID']) &&
    isset($_POST['username'])) {
    $conn = createconn();
    $daysofborrow = get_post($conn, "daysofborrow");
    $bookID = get_post($conn, "bookID");
    $username = get_post($conn, "username");
    $user_id = CheckIfUserExistedRID($username)[1];
    InsertIntoBorrowApplicationTable($user_id, $bookID, $daysofborrow);
    $conn->close();
}