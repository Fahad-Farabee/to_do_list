<?php
include("database.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task</title>
</head>
<body>
    <form action="home.php" method="post">
    <h1> Add a new task </h1><br>
    <label>Task name</label><br>
    <input type="text" name= "taskname"><br>
    <label>Due Time</label><br>
    <input type="time" name= "duetime"><br>
    <input type="submit" name="submit" value="Add">
    
    <h1> Remove a task </h1>
    <label>Task ID</label>
    <input type="text" name="taskid"> <br>
    <input type= "submit" name="tasksubmit"  value="Remove"> <br>

    <h1>Progress</h1><br>
        <?php 
        $query = "SELECT * FROM tasks";
        $resul_query = mysqli_query($connection, $query);
        if(mysqli_num_rows($resul_query) > 0){
            while($rows = mysqli_fetch_assoc($resul_query)){
                echo "<input type='radio' name='task_status' value='".$rows["id"]."'> ";
                echo $rows["id"]. " ", $rows["name"]." ", $rows["due_date"]. " " ,$rows["status"];
                echo "<br>";
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
    //for deletion..
    if(isset($_POST["tasksubmit"])&&!empty($task_id)){
        
        $check_sql = "SELECT * FROM tasks WHERE id = $task_id";
        $check_rslt = mysqli_query($connection, $check_sql);
        if(mysqli_num_rows($check_rslt)>0){
            $dlt_sql = "DELETE FROM tasks WHERE id = $task_id";
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
        
        $sql = "INSERT INTO tasks (id,name,due_date,status) VALUES (NULL,'$task_name', '$due_time','$status')";
        
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
            $update_sql = "UPDATE tasks SET status='Done' WHERE id=$task_id";
            if(mysqli_query($connection, $update_sql)){
                echo "Task status updated to Done";
            } else {
                echo "Error: " . mysqli_error($connection);
            }
        } else {
            echo "No task selected";
        }
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
                <th>ID</th>
                <th>Name</th>
                <th>Due Time</th>
                <th>Status</th>
                
            </tr>
        </thead>
        <tbody>
        <?php
$query = "SELECT * FROM tasks";
$resul_query = mysqli_query($connection, $query);
if(mysqli_num_rows($resul_query)>0){
    while($rows = mysqli_fetch_assoc($resul_query)){
        echo "<tr><td>". $rows["id"]. "</td><td>" . $rows["name"]. "</td><td>". $rows["due_date"]. "</td> <td>". $rows["status"]. "</td></tr>";
        
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