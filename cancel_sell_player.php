<?php

    include("connect.php");

    $loggedUsername=$_GET['username'];
    $playerid=$_GET['playerid'];
   
    
    $sql= "UPDATE player SET transfer_status='unavailable' WHERE player_id = '$playerid'";
        
    $query = mysqli_query($conn, $sql);

    $sql="DELETE FROM transfer WHERE player_id = '$playerid'";

    $query = mysqli_query($conn, $sql);

    $conn->close();
            
    header ("Location: myclub.php? username=$loggedUsername");

               
    
?>