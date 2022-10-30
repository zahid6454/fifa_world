<?php

    include("connect.php");

    $loggedUsername=$_GET['username'];

    $sql="SELECT person.id FROM person WHERE person.username='$loggedUsername'";
        
    $result=mysqli_query($conn,$sql);
    
    while($row = $result->fetch_assoc()) 
    {
        $manager_id= $row["id"];
    }
    
    $sql="UPDATE manager SET leave_wish = 'yes' WHERE manager_id = '$manager_id'";
    
    $query = mysqli_query($conn, $sql);

    $conn->close();

     header ("Location: profile.php? username=$loggedUsername");

    
?>