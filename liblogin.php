<?php
if (isset($_POST['username']) && isset($_POST['password'])) {
    $var1 = $_POST["username"];
    $var2 = $_POST["password"];
    echo $var1;
    echo $var2;
}

