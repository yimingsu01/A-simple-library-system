<?php
require_once "../Model/logincredentials.php";
require_once "../Model/UserActions.php";
require_once "../Model/LostActions.php";
session_start();
$lost_book_id = $_POST["bookID"];
$lost_user_name = $_POST["username"];
$book_res = FindBookByID($lost_book_id);
$lost_book_price = $book_res["price"];
echo <<<_END
    <a>The price you need to pay is: $lost_book_price in RMB</a>
    <form action="../Controller/LostBookContinue.php" method="post">
        <input type="hidden" name="lost_username" value=$lost_user_name>
        <input type="hidden" name="lost_book_id" value=$lost_book_id>
        <input type="hidden" name="lost_book_price" value=$lost_book_price>
        <br>Lost Reason: <input type="text" name="lost_reason">
        <br><br><input type="submit" value="I agree to pay the books price">
    </form>
_END;
