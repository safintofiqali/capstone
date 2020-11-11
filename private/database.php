<?php

require_once("db_credentials.php");

// Open Database Connection
function db_connect(){
    $connection = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
    confirm_db_connect();
    return $connection;
}

// Close Database Connection
function db_disconnect($connection){
    if(isset($connection)) {
        mysqli_close($connection);
    }
}

// Check The Database Connection
function confirm_db_connect(){
    if(mysqli_connect_errno()) {
        $msg = "Database connection failed: ";
        $msg .= mysqli_connect_error();
        $msg .= " ( " . mysqli_connect_errno() . " ) ";
        exit($msg);
    }
}

// Check Result Set of a Query
function confirm_result_set($result) {
    if(!$result) {
        exit("Database Query Failed");
    }
}