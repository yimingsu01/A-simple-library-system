<?php
require_once "../Model/UserActions.php";
session_start();
$old_password = $_POST['old_password'];
$new_password1 = $_POST['new_password1'];
$new_password2 = $_POST['new_password2'];
$new_password = "";
if ($new_password1 == $new_password2) {
    $new_password = $new_password1;
    $username = $_SESSION['username'];
    ChangePassword($username, $old_password, $new_password);
} else {
    echo "New password is different each time.";
    echo "<br><a href='ChangePassword.php'>Back to change password</a>";
}
