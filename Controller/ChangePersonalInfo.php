<form id="basic_info_form" action="ChangePersonalInfo-Continue.php" method="post">
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
    password: <input type="password" name="password">
    <input type="submit" value="Submit">
    <br>
    <input type="submit" value="Submit!">
</form>