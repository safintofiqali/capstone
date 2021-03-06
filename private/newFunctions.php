<?php
function url_for($string)
{
    if ($string[0] !== '/') {
        $string = '/' . $string;
    }
    return WWW_ROOT . $string;
}

// Check Whether argument has value or not
function is_empty($inputs)
{
    if (is_array($inputs)) {
        foreach ($inputs as $input => $value) {
            if (empty($value) || trim($value) === '') {
                return true;
            } else {
                return false;
            }
        }
    } else {
        if (empty($inputs) || trim($inputs) === '') {
            return false;
        } else {
            return true;
        }
    }
}

// Check if username or email is taken
function usernameExists($conn, $username, $email)
{
    $sql = "SELECT * FROM students where std_username = $username of std_email = $email";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $username, $email);
        mysqli_stmt_execute($stmt);
        $user = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($user)) {
            return $row;
        } else {
            return false;
        }
    }
}

// Check for email validity
function validEmail($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

// Check for username validity
function validUsername($username)
{
    if (!preg_match("/^[a-zA-z0-9]*$/", $username)) {
        return true;
    } else {
        return false;
    }
}

// Check if both passwords match
function pwdMatch($pwd, $pwdre)
{
    if ($pwd !== $pwdre) {
        return true;
    } else {
        return false;
    }
}

// Clean values from SQL Injection
function cleanInject($value)
{
    global $conn;
    return mysqli_real_escape_string($conn, $value);
}


// New Select All Function
function selectAll($table) {
    global $conn;
    $sql = "SELECT * FROM `" . $table . "`;";
    $query = mysqli_query($conn,$sql);
    confirm_result_set($query);
    return $query;
}

// Select Instructor
function selectInst($id)
{
    global $conn;
    $sql = "SELECT * FROM instructors WHERE inst_id = '$id'";
    $result = mysqli_query($conn, $sql);
    return $row = mysqli_fetch_assoc($result);
}

// Select Instructor
function selectStd($conn, $id)
{
    $sql = "select * from students where std_id = '$id'";
    $result = mysqli_query($conn, $sql);
    return $row = mysqli_fetch_assoc($result);
}

// Select All Departments 
function selectAllDept($conn)
{
    $sql = "SELECT * FROM department";
    $result = mysqli_query($conn, $sql);
    return $result;
}

// Select All students 
function selectAllStudents($conn, $dept)
{
    $sql = "select * from students where std_major = '$dept'";
    $result = mysqli_query($conn, $sql);
    return $result;
}

// Select * students with limit
function selectLimitedStudents($conn, $dept, $limit)
{
    $sql = "select * from students where std_major = '$dept' limit $limit,10";
    $result = mysqli_query($conn, $sql);
    return $result;
}

// The numbers of rows returned from database
function numOfRows($result)
{
    return mysqli_num_rows($result);
}

// Return url for redirection
function redirect_to($string)
{
    return header("Location:" . $string);
}

// Select All Projects
function selectAllProjects($conn)
{
    $sql = "SELECT * FROM `projects`";
    $result = mysqli_query($conn, $sql);
    return $result;
}

// Select * Projects with limit
function selectLimitedProjects($conn, $dept, $limit)
{
    $sql = "select * from projects where proj_major = '$dept' limit $limit,10";
    $result = mysqli_query($conn, $sql);
    return $result;
}

// Select 5 Recent Projects  
function selectRecentProject($conn)
{
    $sql = "select * from projects order by proj_date limit 5";
    $result = mysqli_query($conn, $sql);
    return $result;
}
// Select 4  Projects  
function selectFourProject($conn, $limit, $posts)
{
    $sql = "SELECT DISTINCT(proj_major) , proj_title , proj_brief, proj_date, proj_id FROM projects ORDER by proj_date LIMIT $limit,$posts";
    $result = mysqli_query($conn, $sql);
    return $result;
}

// Select Project with specific ID
function selectProjectWithId($conn, $id)
{
    $sql = "SELECT * FROM projects where proj_id = $id";
    $result = mysqli_query($conn, $sql);
    $project = mysqli_fetch_assoc($result);
    return $project;
}
// Select Single Photo
function selectPhoto($conn, $proj_id)
{
    $sql = "SELECT * FROM photos where proj_id = $proj_id limit 1";
    $result = mysqli_query($conn, $sql);
    $photo = mysqli_fetch_assoc($result);
    return $photo;
}

function selectPhotos($conn, $proj_id)
{
    $sql = "SELECT * FROM photos where proj_id = $proj_id";
    $result = mysqli_query($conn, $sql);
    return $result;
}


// ----------###---------------
/* ----- New Functions ---- */
// ----------###---------------
function selectProjects($page)
{
    global $conn;
    $sql = "SELECT proj_id,proj_title, SUBSTRING(proj_brief, 1, 80) as 'proj_brief' from projects limit $page,4";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        exit("Query Failed");
    }
    return $result;
}


// Select Limited Ideas
function selectIdeas($page)
{
    global $conn;
    $sql = "SELECT idea_id,idea_title, CONCAT(SUBSTRING(idea_detail, 1, 350),' . . . . Read More') as 'idea_detail', idea_major from ideas limit $page,4";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        exit("Query Failed");
    }
    return $result;
}

// Select All Ideas
function selectAllIdeas()
{
    global $conn;
    $sql = "SELECT * from ideas";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        exit("Query Failed");
    }
    return $result;
}
// Select Single Idea
function selectIdea($idea_id)
{
    global $conn;
    $sql = "SELECT * from ideas where idea_id = $idea_id";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        exit("Query Failed");
    }
    $idea = mysqli_fetch_assoc($result);
    return $idea;
}

function pagination($table)
{
    global $conn;
    $sql = "SELECT * from $table";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        exit("Query Failed");
    }
    $numRows = ceil(mysqli_num_rows($result) / 4);
    for ($i = 0; $i < $numRows; $i++) {
        //    echo "<a href='" .$_SERVER['PHP_SELF'] . "?page=$i'" . " class='pagination_links'>$i</a>";
        echo "<button value=$i id='$i' class='card_paginations'>$i</button>";
    }
}

function selectFile($conn, $id)
{
    $sql = "SELECT * from files where proj_id = $id";
    $result = mysqli_query($conn, $sql);
    return $file = mysqli_fetch_assoc($result);
}
