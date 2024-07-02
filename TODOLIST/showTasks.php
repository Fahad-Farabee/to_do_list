<?php
include ("database.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
$query = "SELECT * FROM tasks";
$resul_query = mysqli_query($connection, $query);
if(mysqli_num_rows($resul_query)>0){
    while($rows = mysqli_fetch_assoc($resul_query)){
        echo $rows["id"]." " ;
        echo $rows["name"]. " ";
        echo $rows["due_date"]. " ";
        echo $rows["status"]. "<br>";
        
    }
}
?>
</body>
</html>