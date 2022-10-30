<?php

    include("connect.php");

    $loggedUsername=$_GET['username'];
    $managerid=$_GET['managerid'];
    
    $club_id=$_GET['club_id'];
    $command=$_GET['command'];

    
        
    if($command==1)
    {
        $sql="UPDATE club SET club.manager_status='unavailable' WHERE club.club_id='$club_id'";
        
        $query=mysqli_query($conn,$sql);
    
        $sql="UPDATE manager
              SET manager.club_id=NULL,
                  manager.contract=NULL,
                  manager.salary=NULL,
                  manager.club_status='unavailable',
                  manager.leave_wish=NULL
              WHERE manager.manager_id='$managerid'";

        $query=mysqli_query($conn,$sql);
        
        
         $date= date("Y-m-d");
        
        $sql="UPDATE manager_history SET leave_date='$date' 
                                  WHERE club_id='$club_id' AND
                                        manager_id='$managerid' AND
                                        leave_date IS NULL";
        
        $query=mysqli_query($conn,$sql);
    
    }
    else if($command==0)
    {
        $sql="UPDATE manager
              SET manager.leave_wish='no'
              WHERE manager.manager_id='$managerid'";

        $query=mysqli_query($conn,$sql);
    }
    
    $conn->close();

    header ("Location: owner.php? username=$loggedUsername");

    
?>