<?php
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "todolist";
    $connection = "" ;

    try{
        $connection = mysqli_connect($db_server,$db_user, $db_pass, $db_name);
        echo "H";
    }
    catch(mysqli_sql_exception){
        echo "server is not connected";
    }

    

?>