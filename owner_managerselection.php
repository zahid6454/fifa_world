<?php
    include("connect.php");
    
    $managerid= $_GET['userid'];
    $username=$_GET['username'];
    $command=$_GET['command'];
    $club_manager_salary=$_GET['club_manager_salary'];

    $sql= "SELECT club_id
           FROM owner NATURAL JOIN person
           WHERE person.username='$username' AND
           		 person.id=owner.owner_id";
    
    $result=mysqli_query($conn,$sql);

    while($row = $result->fetch_assoc()) 
    {
        $owner_club_id= $row['club_id'];
    }
    


    if($command==1)
    {
        $sql= "SELECT manager.point FROM manager WHERE manager.manager_id='$managerid'";
        
        $result=mysqli_query($conn,$sql);

        while($row = $result->fetch_assoc()) 
        {
            $manager_point= $row['point'];
        }
        
        $manager_point+=1;
        
        $sql= "UPDATE club SET manager_status = 'available' WHERE club_id = '$owner_club_id'";
    
        $result=mysqli_query($conn,$sql);
        
        $sql= "DELETE FROM club_request 
               WHERE club_id='$owner_club_id' OR
               id='$managerid'";
    
        $result=mysqli_query($conn,$sql);
           
        $sql= "UPDATE manager 
               SET club_status ='available',club_id='$owner_club_id',salary='$club_manager_salary',point='$manager_point'
               WHERE manager_id= '$managerid'";
    
        $result=mysqli_query($conn,$sql);
        
        
         //------------------------------------------manager History-----------------------------------------------------------
        
        $date= date("Y-m-d");
        
        $sql="INSERT INTO `manager_history` (`manager_id`, `club_id`, `joining_date`, `leave_date`) 
              VALUES ('$managerid', '$owner_club_id', '$date', NULL)";
        
        
        $result=mysqli_query($conn,$sql);
        
        
        
        
        
        
        
        
        
        
        
        
        //------------------------------------------manager History-----------------------------------------------------------
        
        
        
        

    }
    else if($command==0)
    {
        $sql= "DELETE FROM club_request WHERE id='$managerid'";
    
        $result=mysqli_query($conn,$sql);

    }

    $conn->close();

    header ("Location: owner.php?username=$username &loginpass=1");

?>