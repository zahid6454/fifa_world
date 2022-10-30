<?php

    include("connect.php");

    $loggedUsername=$_GET['username'];
    $playerid=$_GET['playerid'];
    $club_name=$_GET['club_name'];
    $command=$_GET['command'];

    if($command==1)
    {
        //-------------new club id----------------------------------------
        $sql="SELECT club.club_id FROM club WHERE club.name='$club_name'";
        
        $result = mysqli_query($conn, $sql);
        
        while($row = $result->fetch_assoc())
        {
            $club_id= $row['club_id'];
        }
        
        //-------------new club id----------------------------------------
        
        
        //----------------------new club budget-----------------------------
        $sql="SELECT club.budget FROM club WHERE club.club_id='$club_id'";
            
        $result = mysqli_query($conn, $sql);
        
        while($row = $result->fetch_assoc())
        {
            $club_budget= $row['budget'];
        }
        
        //----------------------new club budget-----------------------------
        
        
        
        
        
        //-------------manager club id----------------------------------------
        $sql="SELECT club_id 
        FROM person JOIN manager
        ON
        (
            person.id=manager.manager_id AND
            person.username='$loggedUsername'
        )";
        
        $result = mysqli_query($conn, $sql);
        
        while($row = $result->fetch_assoc())
        {
            $myclub_id= $row['club_id'];
        }
        
        //-------------manager club id----------------------------------------
        
        
        //-------------manager club budget----------------------------------------
        $sql="SELECT club.budget FROM club WHERE club.club_id='$myclub_id'";
            
        $result = mysqli_query($conn, $sql);
        
        while($row = $result->fetch_assoc())
        {
            $myclub_budget= $row['budget'];
        }
        
        //-------------manager club budget----------------------------------------
        
        
        //-------------Player Sell Amount----------------------------------------
        
        
        $sql= "SELECT transfer.transfer_price 
                FROM transfer
                WHERE transfer.player_id='$playerid' AND
                      transfer.buyer_club_id='$club_id'";
        
        $result = mysqli_query($conn, $sql);
        
        while($row = $result->fetch_assoc())
        {
            $amount= $row['transfer_price'];
        }
        
        //-------------Player Sell Amount----------------------------------------
        
        
        //-------------Minus amount from new club budget--------------------------
        
        $club_budget = $club_budget - $amount;
        
        $sql="UPDATE club SET budget= '$club_budget' WHERE club_id = '$club_id'";
        
        $result = mysqli_query($conn, $sql);
        
        
        //-------------Minus amount from new club budget-------------------------
        
        
        
        //-------------Add amount from manager club budget-------------------------
        
        $myclub_budget = $myclub_budget + $amount;
        
        $sql="UPDATE club SET budget= '$myclub_budget' WHERE club_id = '$myclub_id'";
        
        $result = mysqli_query($conn, $sql);
        
        
        //-------------Add amount from manager club budget-------------------------
        
        
        //-------------Make History------------------------------------------------
        
        $date= date("Y-m-d");
        
        $sql_buyer_club_history="INSERT INTO player_history
             (
                player_id, 
                club_id, 
                joining_date, 
                leave_date, 
                transfer_price
             ) 
             
             VALUES ('$playerid', '$club_id', '$date', NULL, '$amount')";
            
        $result = mysqli_query($conn, $sql_buyer_club_history);
        
            
        $sql_seller_club_history="UPDATE player_history SET leave_date='$date' 
                                  WHERE club_id='$myclub_id' AND
                                        player_id='$playerid' AND
                                        leave_date IS NULL
                                        ";
        
        $result = mysqli_query($conn, $sql_seller_club_history);
        
        
        
        
        //-------------Make History------------------------------------------------
        
        
        $sql= "UPDATE player SET club_id= '$club_id',transfer_status='unavailable',jersey_no='',squad_status='reserved' WHERE player_id = '$playerid'";
         
        $query = mysqli_query($conn, $sql);
        
        $sql= "DELETE FROM transfer WHERE player_id = '$playerid'";
           
        $query = mysqli_query($conn, $sql);

        $conn->close();
        
        
        

    }
    else if($command==0)
    {
        $sql="SELECT club.club_id FROM club WHERE club.name='$club_name'";
        
        $result = mysqli_query($conn, $sql);
        
        while($row = $result->fetch_assoc())
        {
            $club_id= $row['club_id'];
        }
        
        $sql= "DELETE FROM transfer WHERE player_id = '$playerid' AND buyer_club_id = '$club_id'";
        
        $query = mysqli_query($conn, $sql);

        $conn->close();
    }
   
    
            
    header ("Location: transfer.php? username=$loggedUsername & budget_alert=0");

               
    
?>