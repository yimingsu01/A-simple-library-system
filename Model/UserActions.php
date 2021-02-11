<?php
require_once "logincredentials.php";
function InsertIntoUserApplicationTable($username, $first_name, $last_name, $gender, $age, $password, $safequestions, $safequestions_a, $create_time) {
    global $db_database, $db_hostname, $db_password, $db_username;
    $conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    if ($conn->connect_error) die ($conn->connect_error);
    $query = "insert into user_application (username, first_name, last_name, gender, age, password, safe_questions, safe_questions_answers, create_time) values (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssiissss", $pusername, $pfirst_name, $plast_name, $pgender, $page, $ppassword, $psafequestions, $psafequestions_a, $pcreate_time);
    $pusername = $username;
    $pfirst_name = $first_name;
    $plast_name = $last_name;
    $pgender = $gender;
    $page = $age;
    $ppassword = $password;
    $psafequestions = $safequestions;
    $psafequestions_a = $safequestions_a;
    $pcreate_time = $create_time;
    $stmt->execute();
    echo $stmt->error;
    $affected_rows = $stmt->affected_rows;
    $stmt->close();
    $conn->close();
    if ($affected_rows > 0) {
        return True;
    } else {
        return False;
    }
}

function UserAuthentication($username, $password) {
    $conn = createconn();
//    $query = "select * from user where username=$username";
    $stmt = $conn->prepare("select password from user where username=?");
    $stmt->bind_param("s", $stmtusername);
    $stmtusername = $username;
    $stmt->execute();
    $results = $stmt->get_result()->fetch_all()[0][0];
    $stmt->close();
    $conn->close();
    if ($results === $password) {
        return True;
    } else {
        return False;
    }

}

function ChangePassword($username, $old_password, $new_password) {
    $res = UserAuthentication($username, $old_password);
    if ($res) {
        $conn = createconn();
        $query = "update user set password=? where username=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $stmt_new_password, $stmt_username);
        $stmt_new_password = $new_password;
        $stmt_username = $username;
        $stmt->execute();
        $exec_res = $stmt->affected_rows;
        if ($exec_res == 1) {
            echo "Password successfully changed.";
        }
        $stmt->close();
        $conn->close();
    } else {
        echo "You old password is incorrect.";
        echo "<br><a href='ChangePassword.php'>Back to change password</a>";
    }
}

function ChangeSQ($username, $password, $sq, $sqa) {
    $usr_auth_res = UserAuthentication($username, $password);
    if ($usr_auth_res) {
        $conn = createconn();
        $query = "update user set safe_questions=?, safe_questions_answers=? where username=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $stmt_safe_questions, $stmt_safe_questions_answer, $stmt_username);
        $stmt_safe_questions = $sq;
        $stmt_safe_questions_answer = $sqa;
        $stmt_username = $username;
        $stmt->execute();
        $exec_res = $stmt->affected_rows;
        if ($exec_res == 1) {
            echo "Safe questions successfully changed, ";
            echo "<a href='../dashboard.php'>Back to dashboard</a>";
        }
    } else {
        echo "Wrong password or username, ";
        echo "<a href='../Controller/ChangeSQ.php'>Back to change safe questions page</a>";
    }
}

function FetchingSQandA($username, $password) {
    $res = UserAuthentication($username, $password);
    if ($res) {
        $conn = createconn();
        $query = "select safe_questions, safe_questions_answers from user where username=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $stmt_username);
        $stmt_username = $username;
        $stmt->execute();
        $tot_res = $stmt->get_result()->fetch_all()[0];
        return $tot_res;
    } else {
        echo "Wrong password or username";
    }
}

function FetchingPersonalInfo($username, $password) {
    $res = UserAuthentication($username, $password);
    if ($res) {
        $conn = createconn();
        $query = "select first_name, last_name, gender, age from user where username=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $stmt_username);
        $stmt_username = $username;
        $stmt->execute();
        $res = $stmt->get_result()->fetch_all()[0];
        return $res;
    } else {
        echo "Wrong password or username, ";
        echo "<a href='../Controller/ChangePersonalInfo.php'>Back to change personal information page</a>";
    }
}

function UpdatePersonalInfo($first_name, $last_name, $gender, $age, $username){
    $conn = createconn();
    $query = "update user set first_name=?, last_name=?, gender=?, age=? where username=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssiis", $stmt_first_name, $stmt_last_name, $stmt_gender, $stmt_age, $stmt_username);
    $stmt_first_name = $first_name;
    $stmt_last_name = $last_name;
    $stmt_gender = $gender;
    $stmt_age = $age;
    $stmt_username = $username;
    $stmt->execute();
    $exec_res = $stmt->affected_rows;
    if ($exec_res == 1) {
        echo "Personal information successfully updated.";
    } else {
        echo "Unexpected error happened.";
        echo $stmt->error;
    }
    $stmt->close();
    $conn->close();
}

function LoggingOut() {
    session_start();
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
}

function AdminAuthentication($username, $password) {
    $conn = createconn();
    $stmt = $conn->prepare("select * from user where username=?");
    $stmt->bind_param("s", $stmtusername);
    $stmtusername = $username;
    $stmt->execute();
    $results = $stmt->get_result()->fetch_all()[0];
    if ($results[7] == $password) {
        if ($results[1] == 1) {
            return "true";
        } else {
            return "false";
        }
    }
    $stmt->close();
    $conn->close();
}

function FindRegApplicationByUsername($regusername) {
    $conn = createconn();
    $query = "select * from user_application where username=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $stmtusername);
    $stmtusername = $regusername;
    $stmt->execute();
    $results = $stmt->get_result()->fetch_all()[0];
    $stmt->close();
    $conn->close();
    return $results;
}

function CleaningUserApplication($username) {
    $conn = createconn();
    $stmt = $conn->prepare("select * from user where username=?");
    $stmt->bind_param("s", $var1);
    $var1 = $username;
    $stmt->execute();
    $isUserExisted = False;
    $isRejected = False;
    if ($stmt->get_result()->num_rows > 0) {
        $isUserExisted = True;
    }
    $results = FindRegApplicationByUsername($username);
    if ($results[9] == 0) {
        $isRejected = True;
    }
    if (!isset($results[9])) {
        $isRejected = False;
    }
    $stmt->close();
    $conn->close();
    return [$isUserExisted, $isRejected];
}

function FindBookByTitle($booktitle) {
    $conn = createconn();
    $stmt = $conn->prepare("select * from books where book_name=?");
    $stmt->bind_param("s", $stmt_book_name);
    $stmt_book_name = $booktitle;
    $stmt->execute();
    $res = $stmt->get_result();
    $stmt->close();
    $conn->close();
    return $res->fetch_array();
}

function FindBookByID($bookid) {
    $conn = createconn();
    $stmt = $conn->prepare("select * from books where id=?");
    $stmt->bind_param("s", $stmt_book_id);
    $stmt_book_id = $bookid;
    $stmt->execute();
    $res = $stmt->get_result();
    $stmt->close();
    $conn->close();
    return $res->fetch_array();
}

function FindUserByID($userid) {
    $conn = createconn();
    $stmt = $conn->prepare("select * from user where id=?");
    $stmt->bind_param("s", $stmt_user_id);
    $stmt_user_id = $userid;
    $stmt->execute();
    $res = $stmt->get_result();
    $stmt->close();
    $conn->close();
    return $res->fetch_array();
}

function FindUserIDByUserBookID($user_book_id) {
    $conn = createconn();
    $query = "select * from user_books where id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $stmt_id);
    $stmt_id = $user_book_id;
    $stmt->execute();
    $res = $stmt->get_result()->fetch_all()[0];
    $stmt->close();
    $conn->close();
    return $res;
}

function FindUserByUsername($username) {
    $conn = createconn();
    $stmt = $conn->prepare("select * from user where username=?");
    $stmt->bind_param("s", $stmt_user_name);
    $stmt_user_name = $username;
    $stmt->execute();
    $res = $stmt->get_result();
    $stmt->close();
    $conn->close();
    return $res->fetch_array();
}

function FetchingAllUserApplication() {
    $conn = createconn();
    $stmt = $conn->prepare("select * from user_application");
    $stmt->execute();
    $res = $stmt->get_result()->fetch_all();
    $conn->close();
    $stmt->close();
    return $res;
}

function FetchingAllBorrowApplication() {
    $conn = createconn();
    $stmt = $conn->prepare("select * from borrow_application");
    $stmt->execute();
    $res = $stmt->get_result()->fetch_all();
    $stmt->close();
    $conn->close();
    return $res;
}

function FetchingAllDelayApplication() {
    $conn = createconn();
    $stmt = $conn->prepare("select * from delay_application");
    $stmt->execute();
    $res = $stmt->get_result()->fetch_all();
    $stmt->close();
    $conn->close();
    return $res;
}

function CheckIfBookBorrowed($bookid) {
    $isBorrowed = FindBookByID($bookid)["isBorrow"];
    if ($isBorrowed == 0) {
        return False;
    } else if ($isBorrowed == 1) {
        return True;
    }
}

function InsertIntoUserTable($results) {
    $conn = createconn();
    $query = "insert into user (type, username, first_name, last_name, gender, age, password, safe_questions, safe_questions_answers, status, create_time) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isssiisssis", $stmttype, $stmtusername2, $stmtfirst_name, $stmtlast_name, $stmtgender, $stmtage, $stmtpassword, $stmtsq, $stmtsqa, $stmtstatus, $stmtcreate_time);
    // 2 is user, 1 is admin
    $stmttype = 2;
    $stmtusername2 = $results[1];
    $stmtfirst_name = $results[2];
    $stmtlast_name = $results[3];
    $stmtgender = $results[4];
    $stmtage = $results[5];
    $stmtpassword = $results[6];
    $stmtsq = $results[7];
    $stmtsqa = $results[8];
    $stmtstatus = 1;
    $stmtcreate_time = date("Y-m-d");
    $stmt->execute();
    $exec_res = $stmt->affected_rows;
    if ($exec_res > 0) {
        echo "user $results[1] has been successfully created.";
    } else {
        echo "unexpected error happened";
    }
    $stmt->close();
    $conn->close();
}

function InsertIntoBorrowApplicationTable($user_id, $book_id, $days_of_borrow) {
    $conn = createconn();
    $query = "insert into borrow_application (user_id, book_id, create_time, days_of_borrow, updater, borrow_status) values (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iisiii", $stmt_user_id, $stmt_book_id, $stmt_create_time, $stmt_days_of_borrow, $stmt_updater, $stmt_borrow_status);
    $stmt_user_id = $user_id;
    $stmt_book_id = $book_id;
    $stmt_days_of_borrow = $days_of_borrow;
    $stmt_create_time = date("Y-m-d");
    $stmt_updater = 1;
    $stmt_borrow_status = 3;
    $stmt->execute();
    $exec_res = $stmt->affected_rows;
    print_r($stmt->error);
    if ($exec_res > 0) {
        echo "borrow application has been successfully created.";
    } else {
        echo "unexpected error happened";
    }
    $stmt->close();
    $conn->close();
}

function UpdateRegApplication($updaterid, $regresult, $applicationid) {
    $conn = createconn();
    $query = "update user_application set register_status = ?, updater = ?, update_time = ? where id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isss", $stmtregister_status, $stmtupdater, $stmtupdate_time, $stmt_id);
    $stmtregister_status = $regresult; // 1 - approved, 0 - rejected
    $stmtupdater = $updaterid;
    $stmtupdate_time = date("Y-m-d");
    $stmt_id = $applicationid;
    $stmt->execute();
    $stmt->close();
    $conn->close();
}

function CheckIfUserExistedRID($username) {
    try {
        $conn = createconn();
        $query = "select * from user where username=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $var1);
        $var1 = $username;
        $stmt->execute();
        $exec_results = $stmt->get_result();
        $numrows = $exec_results->num_rows;
        $rows = $exec_results->fetch_all();
        if ($numrows > 0) {
            $user_id = $rows[0][0];
            $stmt->close();
            $conn->close();
            if (isset($exec_results)) {
                return [True, $user_id];
            }
        } else {
            return [False, 0];
        }

    } catch (Exception $e) {
        echo $e;
    }
}

function UpdateBook($book_id, $isBorrow_status) {
    $conn = createconn();
    $query = "update books set isBorrow=? where id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $stmt_isBorrow, $stmt_book_id);
    $stmt_isBorrow = $isBorrow_status;
    $stmt_book_id = $book_id;
    $stmt->execute();
    $exec_res = $stmt->affected_rows;
    $stmt->close();
    $conn->close();
    return $exec_res;
}

function UpdateBorrowApplication($app_id, $updater, $audit_res) {
    $conn = createconn();
    $updater_id = FindUserByUsername($updater)["id"];
    $query = "update borrow_application set updater=?, update_time=?, borrow_status=? where id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isii", $stmt_updater, $stmt_update_time, $stmt_borrow_status, $stmt_id);
    $stmt_updater = $updater_id;
    $stmt_update_time = date("Y-m-d");
    $stmt_borrow_status = $audit_res;
    $stmt_id = $app_id;
    $stmt->execute();
    $exec_res = $stmt->affected_rows;
    $stmt->close();
    $conn->close();
    return $exec_res;
}

function InsertUserBooksTable($book_id, $user_id, $days_of_borrow, $status) {
    $conn = createconn();
    $query = "insert into user_books (book_id, user_id, days_of_borrow, status, create_time) value (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiiis", $stmt_book_id, $stmt_user_id, $stmt_days_of_borrow, $stmt_status, $stmt_create_time);
    $stmt_book_id = $book_id;
    $stmt_user_id = $user_id;
    $stmt_days_of_borrow = $days_of_borrow;
    $stmt_status = $status;
    $stmt_create_time = date("Y-m-d");
    $stmt->execute();
    $exec_res = $stmt->affected_rows;
    $stmt->close();
    $conn->close();
    return $exec_res;
}

function UpdateUserBooksTable($user_id, $book_id, $status) {
    $conn = createconn();
    $query = "update user_books set status=? where user_id=? and book_id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $stmt_status, $stmt_user_id, $stmt_book_id);
    $stmt_status = $status;
    $stmt_user_id = $user_id;
    $stmt_book_id = $book_id;
    $stmt->execute();
    $exec_res = $stmt->affected_rows;
    $stmt->close();
    $conn->close();
    return $exec_res;
}

function FindAllBookIDBorrowedFromAUser($user_id) {
    $conn = createconn();
    $query = "select * from user_books where user_id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $stmt_user_id);
    $stmt_user_id = $user_id;
    $stmt->execute();
    $tot_res = $stmt->get_result()->fetch_all();
    return $tot_res;
}

function FindAllBooks() {
    $conn = createconn();
    $query = "select * from books";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_all();
    return $res;
}





function get_post($conn, $var)
{
    return $conn->real_escape_string($_POST[$var]);
}

function get_get($conn, $var)
{
    return $conn->real_escape_string($_GET[$var]);
}