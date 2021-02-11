<?php
require_once 'Model\logincredentials.php';
require_once 'functions.php';
$conn = new mysqli($db_hostname, $db_username, $db_password, "publications");

if ($conn->connect_error) die ($conn->connect_error);


if (isset($_POST['delete']) && isset($_POST['isbn'])) {
//    Normal Way
//    $isbn = get_post($conn, "isbn");
//    $query = "delete from classics where isbn='$isbn'";
//    $result = $conn->query($query);
//    if (!$result) echo "DELETE failed: $query<br>" . $conn->error . "<br><br>";

    // stmt way
    $stmt = $conn->prepare("delete from classics where isbn = ?");
    $stmt->bind_param("i", $isbn);
    $isbn = get_post($conn, "isbn");
    $stmt->execute();
    $stmt->close();
}

if (isset($_GET['author']) &&
    isset($_GET['title']) &&
    isset($_GET['category']) &&
    isset($_GET['year']) &&
    isset($_GET['isbn'])) {
//     Normal way
//    $author = get_get($conn, 'author');
//    $title = get_get($conn, 'title');
//    $category = get_get($conn, 'category');
//    $year = get_get($conn, 'year');
//    $isbn = get_get($conn, 'isbn');
//    $query = "insert into classics values" . "('$author', '$title', '$category', '$year', '$isbn')";

    $stmt = $conn->prepare("insert into classics values (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssii", $author, $title, $category, $year, $isbn);
    $author = get_get($conn, 'author');
    $title = get_get($conn, 'title');
    $category = get_get($conn, 'category');
    $year = get_get($conn, 'year');
    $isbn = get_get($conn, 'isbn');
    $stmt->execute();

    $stmt->close();

//    $result = $conn->query($query);
//    if (!$result) echo "insert failed: $query<br>" . $conn->error . "<br><br>";
}

// print_r(deleteFromTable($db_hostname, $db_username, $db_password, "publications", "classics", "isbn", "i", 1));
print_r(insertIntoTable($db_hostname, $db_username, $db_password, "publications", "classics", ["ming", "ming", "ming", 1, 12], "sssii"));
echo <<<_END
    <form action="indexprototype.php" method="get"><pre>
    Author <input type="text" name="author">
    Title <input type="text" name="title">
    Category <input type="text" name="category">
    Year <input type="text" name="year">
    ISBN <input type="text" name="isbn">
    <input type="submit" value="ADD RECORD">
    </pre></form>

_END;
// Stmt Way
$stmt = $conn->prepare("select * from classics");
$stmt->execute();
$stmt->bind_result($author, $title, $category, $year, $isbn);

while ($stmt->fetch()) {
    echo <<<_END
    <div style="border: #8b0000 1px solid; margin: 10px 0px; width: 400px">
        <pre>
        Author $author
        Title $title
        Category $category
        Year $year
        ISBN $isbn
        </pre>
        
        <form action="indexprototype.php" method="get"> Update <pre>
        Author <input type="text" name="up_author">
        Title <input type="text" name="up_title">
        Category <input type="text" name="up_category">
        Year <input type="text" name="up_year">
        <input type="hidden" name="up_isbn" value="$isbn">
        <input type="submit" value="UPDATE RECORD">
        </pre></form>
        
        <form action="indexprototype.php" method="post">
        <input type="hidden" name="delete" value="yes">
        <input type="hidden" name="isbn" value="$isbn">
        <input type="submit" value="DELETE RECORD"></form>
    </div>
_END;
}

//print_r(selectAllFromTable($db_hostname, $db_username, $db_password, "publications", "classics"));

$stmt->close();

if (isset($_GET['up_author']) &&
    isset($_GET['up_title']) &&
    isset($_GET['up_category']) &&
    isset($_GET['up_year']) &&
    isset($_GET['up_isbn'])) {

    $stmt = $conn->prepare("update classics set author = ?, title = ?, category = ?, year = ? where isbn = ?");
    $stmt->bind_param("sssii", $author, $title, $category, $year, $isbn);

    $author = get_get($conn, 'up_author');
    $title = get_get($conn, 'up_title');
    $category = get_get($conn, 'up_category');
    $year = get_get($conn, 'up_year');
    $isbn = get_get($conn, 'up_isbn');

    if (empty($author)) {
        $author = get_get($conn, 'author');
    }

    if (empty($title)) {
        $title = get_get($conn, 'title');
    }

    if (empty($category)) {
        $category = get_get($conn, 'category');
    }

    if (empty($year)) {
        $year = get_get($conn, 'year');
    }


    $stmt->execute();
    $stmt->close();

}


//Normal way
//$query = "select * from classics";
//$result = $conn->query($query);
//if (!$result) die ("Database access failed: " . $conn->error);
//$rows = $result->num_rows;
//for ($j = 0; $j < $rows; $j++) {
//    $result->data_seek($j);
//    $row = $result->fetch_array(MYSQLI_NUM);
//
//    echo <<<_END
//    <pre>
//    Author $row[0]
//    Title $row[1]
//    Category $row[2]
//    Year $row[3]
//    ISBN $row[4]
//    </pre>
//    <form action="indexprototype.php" method="post">
//    <input type="hidden" name="delete" value="yes">
//    <input type="hidden" name="isbn" value="$row[4]">
//    <input type="submit" value="DELETE RECORD"></form>
//_END;
//}
//$result->close();


function get_post($conn, $var)
{
    return $conn->real_escape_string($_POST[$var]);
}

function get_get($conn, $var)
{
    return $conn->real_escape_string($_GET[$var]);
}


$conn->close();
