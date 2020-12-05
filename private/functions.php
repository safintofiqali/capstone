<?php
# ------------------------------#
/* - - - Image Functions - - - */
#-------------------------------#
function profileImage($table, $column, $user_id)
{
    global $conn;
    $sql = "SELECT * FROM " . $table . " where " . $column . " = " . $user_id . " AND photo_indication = 0;";
    $query = mysqli_query($conn, $sql);
    // confirm_result_set($query);
    if (!$query) {
        echo mysqli_error($conn);
    }
    $user_image = mysqli_fetch_assoc($query);
    return $user_image;
}

# ------------------------------#
/* - - - User Functions - - - */
#-------------------------------#
function selectUserWithId($table, $id)
{
    global $conn;
    if ($table === 'instructors') {
        $sql = "SELECT * FROM instructors where inst_id = '$id'";
    } else {
        $sql = "SELECT * FROM students where std_id = '$id'";
    }
    $query = mysqli_query($conn, $sql);
    confirm_result_set($query);
    return $user = mysqli_fetch_assoc($query);
}

// Select All students 
function selectAllStudents($dept)
{
    global $conn;
    $sql = "select * from students where std_major = '$dept'";
    $result = mysqli_query($conn, $sql);
    return $result;
}

// Select * students with limit
function selectLimitedStudents($dept, $limit, $id)
{
    global $conn;
    $sql = "select * from students where std_major = '$dept' and inst_id = $id limit $limit,10";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function selectInstStudents($inst_id)
{
    global $conn;
    $sql = "select * from students where inst_id = $inst_id";
    $result = mysqli_query($conn, $sql);
    return $result;
}

# ------------------------------#
/* - - - Project Functions - - - */
#-------------------------------#
// Select All Projects
function selectAllProjects()
{
    global $conn;
    $sql = "SELECT * FROM `projects`";
    $result = mysqli_query($conn, $sql);
    return $result;
}

// Select * Projects with limit
function selectLimitedProjects($dept, $limit)
{
    global $conn;
    $sql = "select * from projects where proj_major = '$dept' limit $limit,10";
    $result = mysqli_query($conn, $sql);
    return $result;
}

// Select * students with limit
function selectLimitedProjectsWithId($dept, $limit, $id)
{
    global $conn;
    $sql = "select * from projects where proj_major = '$dept' and inst_id = $id limit $limit,10";
    $result = mysqli_query($conn, $sql);
    return $result;
}

function selectInstProjects($inst_id)
{
    global $conn;
    $sql = "select * from projects where inst_id = $inst_id";
    $result = mysqli_query($conn, $sql);
    return $result;
}

// Select 5 Recent Projects  
function selectRecentProject()
{
    global $conn;
    $sql = "select * from projects order by proj_date limit 5";
    $result = mysqli_query($conn, $sql);
    return $result;
}
// Select 4  Projects  
function selectFourProject($limit, $posts)
{
    global $conn;
    $sql = "SELECT DISTINCT(proj_major) , proj_title , proj_brief, proj_date, proj_id FROM projects ORDER by proj_date LIMIT $limit,$posts";
    $result = mysqli_query($conn, $sql);
    return $result;
}

// Select Project with specific ID
function selectProjectWithId($id)
{
    global $conn;
    $sql = "SELECT * FROM projects where proj_id = $id";
    $result = mysqli_query($conn, $sql);
    $project = mysqli_fetch_assoc($result);
    return $project;
}
// Select Project with specific ID
function selectStdProjectWithId($id)
{
    global $conn;
    $sql = "SELECT * FROM projects where std_id = $id";
    $result = mysqli_query($conn, $sql);
    $project = mysqli_fetch_assoc($result);
    return $project;
}
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

# ------------------------------#
/* - - - Validation Functions - - - */
#-------------------------------#
// Check Whether argument has value or not
function is_empty($inputs)
{
    $check = '';
    if (is_array($inputs)) {
        foreach ($inputs as $input => $value) {
            if (empty($value) || trim($value) === '') {
                $check = true;
            } else {
                $check = false;
            }
        }
    } else {
        if (empty($inputs) || trim($inputs) === '') {
            $check =  false;
        } else {
            $check =  true;
        }
    }

    return $check;
}

// Check if username or email is taken
function usernameExists($username, $email)
{
    global $conn;
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

function url_for($string)
{
    if ($string[0] !== '/') {
        $string = '/' . $string;
    }
    return WWW_ROOT . $string;
}




// New Select All Function
function selectAll($table)
{
    global $conn;
    $sql = "SELECT * FROM `" . $table . "`;";
    $query = mysqli_query($conn, $sql);
    confirm_result_set($query);
    return $query;
}

// Select All Departments 
function selectAllDept()
{
    global $conn;
    $sql = "SELECT * FROM department";
    $result = mysqli_query($conn, $sql);
    return $result;
}


// The numbers of rows returned from database
function numOfRows($result)
{
    return mysqli_num_rows($result);
}

// Redirect to the Specified location
function redirect_to($string)
{
    return header("Location:" . $string);
}


// Select Single Photo
function selectPhoto($proj_id)
{
    global $conn;
    $sql = "SELECT * FROM photos where proj_id = $proj_id limit 1";
    $result = mysqli_query($conn, $sql);
    $photo = mysqli_fetch_assoc($result);
    return $photo;
}

function selectPhotos($proj_id)
{
    global $conn;
    $sql = "SELECT * FROM photos where proj_id = $proj_id";
    $result = mysqli_query($conn, $sql);
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

// Select Ideas with limit
function selectLimitedIdeas($dept, $limit)
{
    global $conn;
    $sql = "SELECT * FROM ideas WHERE idea_major = '$dept' limit $limit,10";
    $result = mysqli_query($conn, $sql);
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

function selectFile($id)
{
    global $conn;
    $sql = "SELECT * from files where proj_id = $id";
    $result = mysqli_query($conn, $sql);
    return $file = mysqli_fetch_assoc($result);
}

// ####################
// Comments Functions
// ####################
function selectLimitedComments($page,$id){
    global $conn;
    $sql = "SELECT * FROM comments WHERE proj_id = '$id' LIMIT $page,10 ;";
    $result = mysqli_query($conn,$sql);
    confirm_result_set($result);
    return $result;
}

function selectAllComments($id){
    global $conn;
    $sql = "SELECT * FROM comments where proj_id = $id;";
    $result = mysqli_query($conn,$sql);
    confirm_result_set($result);
    return $result;
}