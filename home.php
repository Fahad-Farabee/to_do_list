<?php
session_start();
include("database.php");

// Redirect to login if user is not logged in
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch books of the logged-in user using INNER JOIN
$spl = "SELECT books.book_id, books.book_name FROM books INNER JOIN signedup_user ON books.signup_id = signedup_user.signup_id WHERE books.signup_id = '$user_id'";
$Q = mysqli_query($connection, $spl);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task</title>
</head>
<body>
    <h1> HELLO </h1>
    <form action="home.php" method="post">
    <h1> Add a new task </h1><br>
    <label>Task name</label><br>
    <input type="text" name= "taskname"><br>
    <label>Due Time</label><br>
    <input type="datetime-local" name= "duetime"><br>
    <label>Priority</label>
            <select name="priority">
                <option value="High">High</option>
                <option value="Medium">Medium</option>
                <option value="Low">Low</option>
            </select><br>
    <input type="submit" name="submit" value="Add">
    <input type="submit" name="logout" value="LOGOUT">


    <h1>Progress</h1><br>
        <?php 
        $query = "SELECT * FROM tasks WHERE signup_id = $user_id";
        $resul_query = mysqli_query($connection, $query);
        if(mysqli_num_rows($resul_query) > 0){
            while($rows = mysqli_fetch_assoc($resul_query)){
                echo "<input type='radio' name='task_status' value='".$rows["id"]."'> ";
                echo  $rows["name"]." ", $rows["due_date"]. "<br>";
                
            }
        }
        ?>
        <input type="submit" name="prgs_submit" value="Update Status">

    </form>
    
</body>
</html>



<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $task_name = $_POST["taskname"];
    $due_time = $_POST["duetime"];
    $task_id = $_POST["taskid"];
    $status = "Pending";
    $priority = $_POST["priority"];
    //for deletion..
    if(isset($_POST["tasksubmit"])&&!empty($task_id)){
        
        $check_sql = "SELECT * FROM tasks WHERE id = $task_id AND signup_id = $user_id";
        $check_rslt = mysqli_query($connection, $check_sql);
        if(mysqli_num_rows($check_rslt)>0){
            $dlt_sql = "DELETE FROM tasks WHERE id = $task_id AND signup_id = $user_id";
            if(mysqli_query($connection,$dlt_sql)){
                //echo "Task is deleted";
            }
            else{
                echo "erro: " . mysqli_error($connection);
            }
        }
        else echo "Task ID is not found";
    }
    //for adding
    elseif(!empty($task_name)&&!empty($due_time)&&isset($_POST["submit"])){
        
        $sql = "INSERT INTO tasks (id,name,due_date,status,signup_id,priority) VALUES (NULL,'$task_name', '$due_time','$status', '$user_id', '$priority')";
        
        if(mysqli_query($connection, $sql)){
            //echo "Task added";
        }
        else{
            echo "erro: " . mysqli_error($connection);
        }
    }

    //for updating...
    elseif(isset($_POST["prgs_submit"])){
        if(isset($_POST["task_status"])){
            $task_id = $_POST["task_status"];
            $update_sql = "UPDATE tasks SET status='COMPLETE' WHERE id=$task_id AND signup_id=$user_id";
            if(mysqli_query($connection, $update_sql)){
                echo "Task status updated to Done";
            } else {
                echo "Error: " . mysqli_error($connection);
            }
        } else {
            echo "No task selected";
        }
    }

    elseif(isset($_POST["logout"])){
        include("logout.php");
    }
    //refreshes the page..
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Table</title>
    <style>
            table, th, td {
    border: 1px solid cyan;
    border-radius: 10px;
    padding: 10px;
  }
    </style>
</head>
<body>
    <h1>Database Table</h1>
    <table id="data-table">
        <thead>
            <tr>
                
                <th>Name</th>
                <th>Due Time</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Action</th>
                
            </tr>
        </thead>
        <tbody>
        <?php
$query = "SELECT * FROM tasks WHERE signup_id = $user_id";
$resul_query = mysqli_query($connection, $query);
if(mysqli_num_rows($resul_query)>0){
    while($rows = mysqli_fetch_assoc($resul_query)){
        echo "<tr><td>".$rows["name"]. "</td><td>". $rows["due_date"]. "</td><td>". $rows["status"]. "</td><td>". $rows["priority"]."</td><td><form action='home.php' method='post' style='display:inline;'><input type='hidden' name='taskid' value='".$rows["id"]."'><button type='submit' name='tasksubmit'>🗑️</button></form></td></tr>";
        
    }
}
?>
        </tbody>
    </table>
</body>
</html>


<?php
mysqli_close($connection);
?>