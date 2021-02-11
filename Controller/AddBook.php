<?php
session_start();
if (isset($_SESSION['admin'])) {
    if ($_SESSION['admin'] == "true") {
        echo <<<_END
<form action="AddBook-Continue.php" method="post" enctype="multipart/form-data">
    book title: <input type="text" name="book_name">
    <br>
    isbn: <input type="text" name="isbn">
    <br>
    publisher: <input type="text" name="publisher">
    <br>
    publish_date: <input type="date" name="publish_date">
    <br>
    author: <input type="text" name="author">
    <br>
    price: <input type="number" name="price">
    <br>
    <label for="file">book cover image: </label>
    <input type="file" name="file">
    <br>
    <input type="submit" value="Add Book">
</form>
_END;
    } else {
        echo "You are not an admin, ";
        echo "<a href='../dashboard.php'>Back to dashboard</a>";
    }
} else {
    echo "You haven't login, ";
    echo "<a href='../index.php'>Click here to login</a>";
}


