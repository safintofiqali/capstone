<?php require_once("../private/init.php"); ?>
<?php

if(isset($_POST)) {
    if(is_empty($_POST)) {
        echo "Please fill all the fields";
    } else {
        foreach($_POST as $key => $value) {
            $$key = $value;
        }
    
        $sql = "INSERT INTO ideas(idea_title,idea_detail,idea_date,idea_major,idea_author_email) VALUES (?,?,?,?,?);";
        $stmt = mysqli_stmt_init($conn);
        if(mysqli_stmt_prepare($stmt,$sql)) {
            date_default_timezone_set("Asia/Baghdad");
            $date = date("Y-m-d h:i:s");
            mysqli_stmt_bind_param($stmt,"sssss",$name,$idea,$date,$major,$email);
            if(mysqli_stmt_execute($stmt)) {
                echo "Successfully Submitted, Thanks for your contribution";
            }
        }
    }
    
}

?>