<?php
require_once "../Model/AddBook.php";
if (isset($_POST["book_name"]) &&
    isset($_POST["isbn"]) &&
    isset($_POST["publisher"]) &&
    isset($_POST["publish_date"]) &&
    isset($_POST["author"]) &&
    isset($_POST["price"])) {
    $allowedExts = array("jpeg", "jpg", "png");
    $temp = explode(".", $_FILES["file"]["name"]);
    $extension_name = end($temp);
    if ((($_FILES["file"]["type"] == "image/jpeg")
            || ($_FILES["file"]["type"] == "image/jpg")
            || ($_FILES["file"]["type"] == "image/pjpeg")
            || ($_FILES["file"]["type"] == "image/x-png")
            || ($_FILES["file"]["type"] == "image/png"))
        && ($_FILES["file"]["size"] < 204800)   // 小于 200 kb
        && in_array($extension_name, $allowedExts)) {
        if ($_FILES["file"]["error"] > 0) {
            echo "Error: " . $_FILES["file"]["error"] . "<br>";
        } else {
            if (file_exists("../book_cover/" . $_FILES["file"]["name"])) {
                echo "File existed.";
            } else {
                move_uploaded_file($_FILES["file"]["tmp_name"], "../book_cover/" . $_FILES["file"]["name"]);
            }
        }
    } else {
        echo "invalid file type";
    }

    $book_img_link = "book_cover/" . $_FILES["file"]["name"];
    $book_name = $_POST["book_name"];
    $isbn = $_POST["isbn"];
    $publisher = $_POST["publisher"];
    $publish_date = $_POST["publish_date"];
    $author = $_POST["author"];
    $price = $_POST["price"];

    InsertIntoBookTable($book_name, $isbn, $publisher, $publish_date, $author, $price, $book_img_link);
}


