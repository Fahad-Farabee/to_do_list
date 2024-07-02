<?php
include ("database.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Table</title>
    <link rel="stylesheet" href="style.css">
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
