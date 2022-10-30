<?php
include("connect.php");


$club=$_GET['club_id'];
$manager_id=$_GET['managerid'];
$manager_username=$_GET['manager_username'];
$command=$_GET['command'];

if($command==1)
{
    $sql = "INSERT INTO club_request
        (
            id,club_id
        )

        VALUES('$manager_id','$club')";
}
else if($command==0)
{
    $sql= "DELETE FROM club_request
           WHERE id = '$manager_id' AND club_id = '$club'";
}

$query = mysqli_query($conn, $sql);

$conn->close();




header ("Location: x24.php?username=$manager_username&loginpass=0 & manager_id=$manager_id");
?>
