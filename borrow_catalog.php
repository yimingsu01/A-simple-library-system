<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Borrow Catalog</title>
    <link rel="stylesheet" type="text/css" href="catalog-css.css">
</head>
<body>
<a href='dashboard.php'>to dashboard</a>
<form method="get" action="borrow_catalog.php" id="form">
    <a class="labels">Keyword: </a> <input type="text" name="kword">
    <a class="labels">Category: </a>
    <select name="sq1">
        <option value="1">1</option>
    </select>
    <input type="submit" value="Search">
</form>
<div id="display-box">

    <?php
    session_start();
    require_once "Model/logincredentials.php";
    require_once "Model/UserActions.php";
    $allbooks = FindAllBooks();
    $n = 0;
    $username = $_SESSION['username'];
    while ($n < count($allbooks)) {
        $current_row = $allbooks[$n];
        $db_id = $current_row[0];
        $db_book_name = $current_row[1];
        $db_isBorrow = $current_row[7];
        $db_img_link = $current_row[8];
        $n ++;
        if ($db_isBorrow == 0) { // 0 - not borrowed, 1 - borrowed
            echo <<<_END
            <div class="item">
                <div class="imgs">
                    <img src="$db_img_link">
                </div>
                <a>Book Title: <br><a id="bookname">$db_book_name</a></a>
                <a id="book-id" hidden>$db_id</a>
                <a id="username" hidden>$username</a>
                <br>
                <button class="borrow-button" onclick="displayBorrowWindow()">Borrow This Book</button>
            </div>
_END;
        }
    }

    ?>


</div>


<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close" onclick="close()">&times;</span>
        <div class="content">
            <p>Borrowing "book title"</p>
            <img src="ayase2.png" id="imgs">
            <p id="booktitle">"Book title"</p>
            <form id="borrowForm" action="Controller/BorrowBook.php" method="post">
                <a>Days of Borrow: </a> <input type="text" name="daysofborrow">
                <input id="bookId" type="hidden" name="bookID">
                <input id="username" type="hidden" name="username">
                <input type="submit" value="Confirm">
            </form>
        </div>
    </div>

</div>

<script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal

    function displayBorrowWindow() {
        modal.style.display = "block";
        var bookTitleInModel = modal.children[0].children[1].children[2];
        var modalTitle = modal.children[0].children[1].children[0];
        var bookId = event.target.parentElement.children[3].innerHTML;
        var borrowingFormID = modal.children[0].children[1].children[3].children[2]
        var username = modal.children[0].children[1].children[3].children[3];
        var imglink = modal.children[0].children[1].children[1];

        modalTitle.innerHTML = "Borrowing: " + event.target.parentElement.children[2].innerHTML;
        bookTitleInModel.innerHTML = "Book title: " + event.target.parentElement.children[2].innerHTML;
        borrowingFormID.value = bookId;
        username.value = event.target.parentElement.children[4].innerHTML;
        imglink.src = event.target.parentElement.children[0].children[0].src;
        // console.log(event.target.parentElement.children[4].innerHTML);
        //console.log(event.target.parentElement.children[0].children[0].src);
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        modal.style.display = "none";
    }


</script>
</body>
</html>