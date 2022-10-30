<?php

    include("connect.php");

    $loggedUsername=$_GET['username'];
    $playerid=$_GET['playerid'];
    $club_id=$_GET['club_id'];
    $command=$_GET['command'];
    $price=$_GET['price'];

    
        if($command==1)
        {
            $sql= "INSERT INTO transfer(player_id, buyer_club_id, transfer_price) VALUES ('$playerid','$club_id', $price)";

            $query = mysqli_query($conn, $sql);

            $conn->close();

        }
        else if($command==0)
        {
            $sql= "DELETE FROM transfer WHERE player_id = '$playerid' AND buyer_club_id = '$club_id'";

            $query = mysqli_query($conn, $sql);

            $conn->close();
        }



        header ("Location: transfer.php? username=$loggedUsername & budget_alert=0");
    



    

               
    
?>