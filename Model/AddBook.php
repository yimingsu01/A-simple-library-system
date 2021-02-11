<?php
require_once "logincredentials.php";
function InsertIntoBookTable($book_name, $isbn, $publisher, $publish_date, $author, $price, $img_link) {
    $conn = createconn();
    $query = "insert into books (book_name, isbn, publisher, publish_date, author, price, img_link) value (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssds", $stmt_book_name, $stmt_isbn, $stmt_publisher, $stmt_publish_date, $stmt_author, $stmt_price, $stmt_img_link);
    $stmt_book_name = $book_name;
    $stmt_isbn = $isbn;
    $stmt_publisher = $publisher;
    $stmt_publish_date = $publish_date;
    $stmt_author = $author;
    $stmt_price = $price;
    $stmt_img_link = $img_link;
    $stmt->execute();
    $exec_res = $stmt->affected_rows;
    if ($exec_res == 1) {
        echo "Book Successfully added!";
        echo "<br>";
        echo "<a href='../dashboard.php'>Back to dashboard</a>";
    } else {
        echo $stmt->error;
    }
}

function UploadBookCover() {
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
    return $book_img_link;
}
