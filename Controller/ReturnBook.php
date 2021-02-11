<?php
require_once "../Model/logincredentials.php";
require_once "../Model/UserActions.php";
require_once "../Model/ReturnActions.php";
session_start();
$returning_user_id = $_SESSION["id"];
$returning_user_name = $_POST["username"];
$returning_book_id = $_POST["bookID"];
$IfOvertime = CheckIfOvertime($returning_book_id, $returning_user_id);
if ($IfOvertime[0] == True) {
    echo 1;
    $_SESSION['overtime'] = 0;
    echo <<<_END
    <a>You failed to return the book in agreed date.</a>
    <a>You need to Pay: $IfOvertime[1] in RMB</a>
    <form action="ReturnBookOvertime.php" method="post">
    <input type="hidden" name="pay" value=1>
    <input type="submit" value="I agree to pay this amount of money">
</form>
_END;
} else if ($IfOvertime[0] == False) {
    echo 2;
    ReturningBook($returning_book_id, $returning_user_id);
}

