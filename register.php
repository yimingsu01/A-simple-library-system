<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="register-css.css">
</head>
<body>
<div id="basic_information">
    <form id="basic_info_form" action="Controller/SubUserApp.php" method="get" id="upper_fields">
        <a class="labels">Username: </a> <input class="fields" type="text" name="username">
        <br>
        <a class="labels">Password: </a> <input class="fields" type="password" name="password">
        <br>
        <a class="labels">First Name: </a> <input class="fields" type="text" name="first_name">
        <br>
        <a class="labels">Last Name: </a> <input class="fields" type="text" name="last_name">
        <br>
        <a class="labels">Gender: </a>
        <select name="gender">
            <option value="0">Male</option>
            <option value="1">Female</option>
            <option value="2">Other</option>
        </select>
        <a class="labels">Age: </a> <input class="fields" type="text" name="age">
        <br>

        <a class="labels">Safe Question 1: </a>
        <select name="sq1">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        <a class="labels">Answer: </a> <input class="fields" type="text" name="sq1a">
        <br>

        <a class="labels">Safe Question 2: </a>
        <select name="sq2">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        <a class="labels">Answer: </a> <input class="fields" type="text" name="sq2a">
        <br>

        <a class="labels">Safe Question 3: </a>
        <select name="sq3">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        <a class="labels">Answer: </a> <input class="fields" type="text" name="sq3a">
        <br>
        <input type="submit" value="Register">
    </form>
    <button>Have an account already? Login here.</button>
</div>
</body>
</html>