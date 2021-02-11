<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ming's Library</title>
    <link rel="stylesheet" type="text/css" href="index-css.css">
</head>
<body>
<?php
session_start();
if (isset($_SESSION["login"])) {
    header("Location: dashboard.php");
}
?>
    <div id="total_container">
        <div>
            <p id="header">Library System</p>
        </div>

        <form action="Controller\Login.php" method="POST" id="text_fields">
            <a class="labels">Username:</a>
            <br>
            <input class="fields" type="text" name="username">
            <br>
            <a class="tool-labels">Forgot username?</a>
            <br>
            <a class="labels">Password:</a>
            <br>
            <input class="fields" type="password" name="password">
            <br>
            <a class="tool-labels" title="不会吧不会吧，不会有人连密码都记不住吧？不会吧不会吧，那个人不会是你吧？">Forgot password?</a>
            <br>
            <br>
            <div class="btn-group">
                <input type="submit" value="Login">
                <button><a href="register.php">Register</a></button>
                <button>Management</button>
            </div>
        </form>
    </div>
<script language="php" src="Model/logincredentials.php"></script>
</body>
</html>