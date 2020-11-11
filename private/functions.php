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
function cleanInject($conn, $value)
{
    return mysqli_real_escape_string($conn, $value);
}

// Select Instructor
function selectInst($conn,$id) {
    $sql = "select * from instructors where inst_id = '$id'";
    $result = mysqli_query($conn,$sql);
    return $row = mysqli_fetch_assoc($result);
}

// Select Instructor
function selectStd($conn,$id) {
    $sql = "select * from students where std_id = '$id'";
    $result = mysqli_query($conn,$sql);
    return $row = mysqli_fetch_assoc($result);
}

// Select All Departments 
function selectAllDept($conn){
    $sql = "SELECT * FROM department";
    $result = mysqli_query($conn,$sql);
    return $result;
}

// Select * students 
function selectAllStudents($conn,$dept) {
    $sql = "select * from students where std_major = '$dept'";
    $result = mysqli_query($conn,$sql);
    return $result;
}

// Select * students with limit
function selectLimitedStudents($conn,$dept,$limit) {
    $sql = "select * from students where std_major = '$dept' limit $limit,10";
    $result = mysqli_query($conn,$sql);
    return $result;
}

function numOfRows($result) {
    return mysqli_num_rows($result);
}

function redirect_to($string) {
    return url_for($string);
}

// Select All Projects
function selectAllProjects($conn,$dept) {
    $sql = "SELECT * FROM projects where proj_major = '$dept'";
    $result = mysqli_query($conn,$sql);
    return $result;
}

// Select * Projects with limit
function selectLimitedProjects($conn,$dept,$limit) {
    $sql = "select * from projects where proj_major = '$dept' limit $limit,10";
    $result = mysqli_query($conn,$sql);
    return $result;
}