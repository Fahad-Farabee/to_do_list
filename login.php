<?php
session_start();
include("database.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>
    <form action="login.php" method="post">
        <label>Username: </label>
        <input type="text" name="login_username"><br>
        <label>Password: </label>
        <input type="password" name="login_password" ><br>
        <input type="submit" name="login_submit" value="LOG IN">
        <a href="signup.php"><button type="button">SIGN UP</button></a>
    </form>
</body>
</html>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $_POST["login_username"];
    $pass = $_POST["login_password"];
    if(isset($_POST["login_submit"])&& !empty($name) && !empty($pass)){
        $find_user_sql = "SELECT * FROM signedup_user WHERE signup_username = '$name' ";
        $find_user_query = mysqli_query( $connection, $find_user_sql);
        if(mysqli_num_rows($find_user_query)>0){
            echo "H";
           while($row = mysqli_fetch_assoc($find_user_query)){
            echo "I";
            if(password_verify($pass, $row['signup_password'])){
                $_SESSION['user_id'] = $row['signup_id'];
                header("Location: home.php");
                exit();
            }
           }
        }
        else echo "invalid user name or password";
    }
}
mysqli_close( $connection);
?>
