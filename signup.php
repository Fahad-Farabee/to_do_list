<?php
include("database.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="signup.php" method="post">
        <label> Username:  </label>
        <input type="text" name="signup_username"><br>
        <label> Password:  </label>
        <input type="password" name="signup_password"><br>
        <label> Email:  </label>
        <input type="text" name="signup_email"><br>
        <label> Phone Number: +880  </label>
        <input type="text" name="signup_phone"><br>
        <input type="submit" name="signup_submit" value="CONFIRM">
        <a href="login.php">
        <button type="button"> GO BACK </button>
        </a>
    </form>
</body>
</html>

<?php

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username = $_POST["signup_username"];
    $password = $_POST["signup_password"];
    $email = $_POST["signup_email"];
    $phone = $_POST["signup_phone"];

    if(isset($_POST["signup_submit"]) && !empty($username) && !empty($password) && !empty($email) && !empty($phone)){
        $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
        $input_sql = "INSERT INTO signedup_user (signup_username,signup_password,signup_email,signup_phone) VALUES ( '$username', '$hashed_pass', ' $email', '$phone' )";
        $find_username_sql = "SELECT signup_username FROM signedup_user WHERE signup_username = '$username' ";
        $find_username_query = mysqli_query( $connection, $find_username_sql); 
        $find_email_sql = "SELECT signup_email FROM signedup_user WHERE signup_email = '$email' ";
        $find_email_query = mysqli_query( $connection, $find_email_sql);
        $find_phone_sql = "SELECT signup_phone FROM signedup_user WHERE signup_phone = $phone ";
        $find_phone_query = mysqli_query( $connection, $find_phone_sql);
        $valid_email = filter_var($email, FILTER_VALIDATE_EMAIL);
        $valid_phone = filter_var($phone, FILTER_VALIDATE_INT);
        if(mysqli_num_rows($find_username_query)>0 ){
            echo "username already exits";
        }
        elseif(mysqli_num_rows($find_email_query)>0 ){
            echo "email already exits";
        }
        elseif(mysqli_num_rows($find_phone_query)>0 ){
            echo "phone number already exits";
        }
        elseif($valid_email == false){
            echo "EMAIL DOMAIN IS NOT RIGHT!!";
        }
        elseif($valid_phone==false){
            echo "PHONE NOT VALID";
        }
        else{
            $input_query = mysqli_query( $connection, $input_sql);
        }

    }

   
}


?>



<?php
mysqli_close( $connection);
?>