<?php
function selectAllFromTable($host, $username, $pw, $db, $table_name) {
    $conn = new mysqli($host, $username, $pw, $db);
    if ($conn->connect_error) die ($conn->connect_error);
    $stmt = $conn->prepare("select * from $table_name");
    $stmt->execute();
    $results = $stmt->get_result();
    $stmt->close();
    $conn->close();
    return $results->fetch_all();
}

function insertIntoTable($host, $username, $pw, $db, $table_name, $content_array, $type) {
    $conn = new mysqli($host, $username, $pw, $db);
    if ($conn->connect_error) die ($conn->connect_error);
    $query = "insert into $table_name values (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param($type, $var1, $var2, $var3, $var4, $var5);
    $var1 = $content_array[0];
    $var2 = $content_array[1];
    $var3 = $content_array[2];
    $var4 = $content_array[3];
    $var5 = $content_array[4];
    $stmt->execute();
    $affectedrows = $stmt->affected_rows;
    $stmt->close();
    $conn->close();
    return $affectedrows;
}

function deleteFromTable($host, $username, $pw, $db, $table_name, $primary_key_name, $pk_type, $pk_value) {
    $conn = new mysqli($host, $username, $pw, $db);
    if ($conn->connect_error) die ($conn->connect_error);
    $total_query = "delete from $table_name where $primary_key_name = ?";
    $stmt = $conn->prepare($total_query);
    $stmt->bind_param($pk_type, $pk_in_table);
    $pk_in_table = $pk_value;
    $stmt->execute();
    $affectedrows = $stmt->affected_rows;
    $stmt->close();
    $conn->close();
    return $affectedrows;
}

function updateToTable($host, $username, $pw, $db, $table_name, $content_array, $type) {
    $conn = new mysqli($host, $username, $pw, $db);
    if ($conn->connect_error) die ($conn->connect_error);
    $query = "update $table_name set author = ?, title = ?, category = ?, year = ? where isbn = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param($type, $var1, $var2, $var3, $var4, $var5);
    $var1 = $content_array[0];
    $var2 = $content_array[1];
    $var3 = $content_array[2];
    $var4 = $content_array[3];
    $var5 = $content_array[4];
    $stmt->execute();
    $affectedrows = $stmt->affected_rows;
    $stmt->close();
    $conn->close();
    return $affectedrows;
}

