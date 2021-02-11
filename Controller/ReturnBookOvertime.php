<?php
require_once "../Model/logincredentials.php";
require_once "../Model/UserActions.php";
require_once "../Model/ReturnActions.php";
session_start();
if (isset($_POST["pay"])) {
    ReturningBook($returning_book_id, $returning_user_id);
}