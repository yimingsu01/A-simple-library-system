<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Loss Catalog</title>
    <link rel="stylesheet" type="text/css" href="catalog-css.css">
</head>
<body>
<a href='dashboard.php'>to dashboard</a>
<div id="display-box">
    <?php
    session_start();
    require_once "Model/logincredentials.php";
    require_once "Model/UserActions.php";
    $borrowed_books = FindAllBookIDBorrowedFromAUser($_SESSION['id']);
    $n = 0;
    $username = $_SESSION['username'];
    while ($n < count($borrowed_books)) {
        $current_row = $borrowed_books[$n];
        $db_book_id = $current_row[1];
        $db_user_id = $current_row[2];
        $db_status = $current_row[4];
        $db_book_name = FindBookByID($db_book_id)['book_name'];
        $db_img_link = FindBookByID($db_book_id)['img_link'];
        if ($db_status == 1 || $db_status == 2) { // 0 - returned, 1 - borrowing, 2 - overtime 3 - lost the book
            echo <<<_END
            <div class="item">
                <div class="imgs">
                    <img src="$db_img_link" alt="img link">
                </div>
                <a>Book Title: <br><a id="bookname">$db_book_name</a></a>
                <a id="book-id" hidden>$db_book_id</a>
                <a id="username" hidden>$username</a>
                <br>
                <button class="borrow-button" onclick="displayBorrowWindow()">I Lost This Book!</button>
            </div>
_END;
        }
        $n ++;
    }

    ?>
</div>


<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close" onclick="close()">&times;</span>
        <div class="content">
            <p>Returning "book title"</p>
            <img src="ayase2.png" id="imgs">
            <p id="booktitle">"Book title"</p>
            <form id="returnForm" action="Controller/LostBook.php" method="post">
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
        var imglink = modal.children[0].children[1].children[1];
        var username = modal.children[0].children[1].children[3].children[1];
        var bookID = event.target.parentElement.children[3].innerHTML;
        var FormbookID = modal.children[0].children[1].children[3].children[0];
        FormbookID.value = bookID;
        modalTitle.innerHTML = "Returning: " + event.target.parentElement.children[2].innerHTML;
        bookTitleInModel.innerHTML = "Book title: " + event.target.parentElement.children[2].innerHTML;
        imglink.src = event.target.parentElement.children[0].children[0].src;
        username.value = event.target.parentElement.children[4].innerHTML;

        console.log(event.target.parentElement.children[3]);
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        modal.style.display = "none";
    }


</script>
</body>
</html>