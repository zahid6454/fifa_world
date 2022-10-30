<?php

    include("connect.php");

    $loggedUsername=$_GET['username'];
    $playerid=$_GET['playerid'];
    $status=$_GET['status'];
    
    $sql="UPDATE player SET squad_status = '$status' WHERE player_id = '$playerid'";
    
    $query = mysqli_query($conn, $sql);

    $conn->close();

    header ("Location: squad.php? username=$loggedUsername");

    
?>