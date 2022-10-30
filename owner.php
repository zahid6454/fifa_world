<?php

    include("connect.php");

    $request_flag=0;

    $loggedUsername=$_GET['username'];

    $query = "SELECT club.club_id,club.manager_salary
              FROM club
              WHERE club_id IN
              (
	               SELECT owner.club_id 
	               FROM owner NATURAL JOIN person
	               WHERE person.username='$loggedUsername' AND
	               owner.owner_id=person.id
              )
              ";

    $result=mysqli_query($conn,$query);

    while($row = $result->fetch_assoc())
    {
        $owner_clubid= $row['club_id'];
        $club_manager_salary= $row['manager_salary'];
    }


    $query="SELECT club.manager_status FROM club WHERE club.club_id=$owner_clubid";

    $result=mysqli_query($conn,$query);

    while($row = $result->fetch_assoc())
    {
        $manager_status= $row['manager_status'];
    }

    if($manager_status=='available')
    {
        $query="SELECT person.name,manager.manager_id,manager.leave_wish 
                FROM manager JOIN person
                ON person.id=manager.manager_id
                WHERE manager.club_id='$owner_clubid'";
        
        $result1=mysqli_query($conn,$query);

        while($row = $result1->fetch_assoc())
        {
            $manager_name=$row['name'];
            $manager_id= $row['manager_id'];
            $leave_wish= $row['leave_wish'];
        }
        
        if($leave_wish=='yes')
        {
            $request_flag=1;
        }
        
    }
    else
    {
        $request_flag=0;
    }


    $query = "SELECT person.id,person.name,person.type,person.country,person.DOB,person.mail
              FROM person NATURAL JOIN club_request NATURAL JOIN owner
              WHERE club_request.club_id='$owner_clubid'
              ";
    
    $result=mysqli_query($conn,$query);




?>




<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Owner</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/shop-homepage.css" rel="stylesheet">
    
    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style >


        body
        {
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-position: 0 ;
            padding-top:20px;
        }
        
        /* Table Part */
        
        #logo
        {
            display: block;
            margin: 0 auto;
        }
        
        .request_header
        {
            text-align: center;
            color: #141414;
            font-family: arial;
            
        }
        
        .request_table
        {
            margin: auto;
            margin-top: 35px;
            border-collapse:separate;
            border: solid #141414 2px;
            border-radius: 20px;
            width: 100%;
        }
        
        .table_head
        {
            color: #141414;
            font-size: 22px;
            font-family: arial;
            
        }
        
        .table_body
        {
            color: #141414; 
            font-size: 19px;
            font-family: Segoe UI;
        }

        td, th 
        {
            border: 3px #141414;
            text-align: center;
            padding: 8px;
            
        }
        
        
        #history_button
        {
            position: relative;
            display: inline-block;
            padding: 6px 12px;
            
            background-color: blue;
            background: linear-gradient(#6f0000,#200122);

            border-radius: 5px;
            color: #fff;
            font-size: 18px;
            font-weight: 600;
            border: none;
            outline: none;
        }
        #history_button:after
        {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: calc(100% - 4px);
            height: 50%;
            border-radius: 5px;
            background: linear-gradient(rgba(255,255,255,0.8), rgba(255,255,255,0.2));
        }
        #history_button:hover 
        {
            color: white;
            opacity: 0.8;
        }
        

        #approve_button
        {
            position: relative;
            display: inline-block;
            padding: 6px 12px;
            
            background-color: blue;
            background: linear-gradient(#00c6ff,#0072ff);

            border-radius: 5px;
            color: #fff;
            font-size: 18px;
            font-weight: 600;
            border: none;
            outline: none;
        }
        #approve_button:after
        {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: calc(100% - 4px);
            height: 50%;
            border-radius: 5px;
            background: linear-gradient(rgba(255,255,255,0.8), rgba(255,255,255,0.2));
        }
        #approve_button:hover 
        {
            color: white;
            opacity: 0.8;
        }
        
        #decline_button
        {
            position: relative;
            display: inline-block;
            padding: 6px 12px;
            
            background-color: red;
            background: linear-gradient(#e52d27,#b31217);

            border-radius: 5px;
            color: #fff;
            font-size: 18px;
            font-weight: 600;
            border: none;
            outline: none;
        }
        #decline_button:after
        {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: calc(100% - 4px);
            height: 50%;
            border-radius: 5px;
            background: linear-gradient(rgba(255,255,255,0.8), rgba(255,255,255,0.2));
        }
        #decline_button:hover 
        {
            color: white;
            opacity: 0.8;
        }
        
        
        
        
        .req_delete_button
        {
             
            color: #fff;
            background-color: #FE2E2E;
            border-radius: 4px;
            border: none;
            border-bottom: 4px solid #B40404;
            outline: none;
        }

        /*---------*/

        
        /* Other Parts */
        
        .panel
        {
            height: 150px;
            border-width: medium;
            border-color: #141414;
        }
        
        .panel,.col-md-4,.fa
        {
            border-radius: 15px;
        }
        
        .panel-heading
        {
            border-radius: 8px;
        }
        
        .panel-default > .panel-heading 
        {
            background-color: #141414;
            color: white;
        }
        
        .col-lg-12
        {
            margin-top: 30px;
            font-size: 15px;
            font-family: Segoe UI Semibold;
        }
        
        /*--------------*/
        
        #notification
        {
            <?php
                if($request_flag==0)
                { ?>
                    display: none;
                <?php
                }
                 else if($request_flag==1)
                 { ?>
                    display:block;
                <?php
                 }
                ?>
            background: black;
            height: 50px;
            background: linear-gradient(#000000,#434343); 
        }
        
        #accept_button
        {
            margin-left: 10%;
            position: relative;
            display: inline-block;
            padding: 6px 12px;
            margin-top: 0.5%;
            
            background-color: blue;
            background: linear-gradient(#3c9125,#52c234);

            border-radius: 5px;
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            border: none;
            outline: none;
        }
        #accept_button:after
        {
            
            margin-top: 0.5%;
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: calc(100% - 4px);
            height: 50%;
            border-radius: 5px;
            background: linear-gradient(rgba(255,255,255,0.8), rgba(255,255,255,0.2));
        }
        #accept_button:hover 
        {
            color: white;
            opacity: 0.8;
        }
        
        #cancel_button
        {
            margin-top: 0.5%;
            margin-left: 1%;
            position: relative;
            display: inline-block;
            padding: 6px 12px;
            
            background-color: red;
            background: linear-gradient(#e52d27,#b31217);

            border-radius: 5px;
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            border: none;
            outline: none;
        }
        #cancel_button:after
        {
            margin-top: 0.5%;
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: calc(100% - 4px);
            height: 50%;
            border-radius: 5px;
            background: linear-gradient(rgba(255,255,255,0.8), rgba(255,255,255,0.2));
        }
        #cancel_button:hover 
        {
            color: white;
            opacity: 0.8;
        }
        
        
        
        #icon
        {
            margin-left: 5%;
            font-size: 15px;
            color: yellow;
            background-color: rgba(255,255,255,0);
            border: none;
            outline: none;
        }
        #head2
        {
            margin-left: 1%; 
            font-size: 18.5px;
            font-weight: 600;
            color: white;
            padding-left: 15x;
            font-family: Segoe UI Light;
        }
        
        
        
        
        /*----------------------*/
        .container_animate 
        {
            padding: 20px;
        }

        span.psw 
        {
            float: right;
            padding-top: 20px;
        }

        /* The Modal (background) */
        .modal 
        {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            padding-top: 60px;
        }

        /* Modal Content/Box */
        .modal-content 
        {
            
            background-color: black;
            background: linear-gradient(#000000,#434343);
            margin: 0% auto 0% auto; /* 5% from the top, 15% from the bottom and centered */
            border: 1px solid #888;
            width: 70%; /* Could be more or less, depending on screen size */
        }

        /* Add Zoom Animation */
        .animate 
        {
            -webkit-animation: animatezoom 0.6s;
            animation: animatezoom 0.6s
        }

        @-webkit-keyframes animatezoom 
        {
            from {-webkit-transform: scale(0)} 
            to {-webkit-transform: scale(1)}
        }
            
        @keyframes animatezoom
        {
            from {transform: scale(0)} 
            to {transform: scale(1)}
        }
        
        .history_header
        {
            text-align: center;
            color:  white;
        }
        
        .history_table
        {
            margin: auto;
            margin-top: 35px;
            width:100%;
            border-collapse:separate;
            border: solid white 2px;
            border-radius: 10px;
        }
        
        .history_table_head
        {
            color: white;
            font-size: 22px;
            font-family: arial;
        }
        
        .history_table_body
        {
            color: white;
            font-family: Segoe UI;
        }

        #column,#head
        {
            border: 3px white;
            text-align: center;
            padding: 8px;
            color: white;
        }
        #head
        {
            font-size: 20px;   
        }

    </style>

</head>

<body>
    <!-- Page Content -->
    <div class="container">
       
        
        <!------------------>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div id="notification" class="panel">
                    <div class="flex-container">
                        <button id="icon" class="glyphicon glyphicon-envelope"></button>
                        <label id="head2"><?php echo $manager_name ?> requested for his resign...</label>
                        <button id="accept_button" class="glass" type="button" onclick="resign('<?php echo $manager_id; ?>',1)" name="accept" value="Accept">Accept</button>
                        <button id="cancel_button" class="glass" type="button" onclick="resign('<?php echo $manager_id; ?>',0)" name="cancel" value="Cancel">Cancel</button>
                        
                        <script language="javascript">
                            
                            function resign(managerid,command)
                            {
                                username='<?php echo $loggedUsername ?>';
                                club_id='<?php echo $owner_clubid ?>';
                                
                                window.location.href='owner_managerresign.php?username='+username+'& managerid='+managerid+'& club_id='+club_id+'& command='+command+'';
                            }
                        </script>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
            
        </div>
        <!-- Table Part -->

        <div class="row">
        
            <div class="col-md-12">
                
                
                
                
                <?php if($owner_clubid=='00000'){ ?>
                    <img id="logo" src="real_madrid.jpg">
                <?php } else if($owner_clubid=='00001') { ?> 
                    <img id="logo" src="barcelona.jpg">
                <?php } else if($owner_clubid=='00002') { ?> 
                    <img id="logo" src="manchester_united.jpg">
                <?php } else if($owner_clubid=='00003') { ?> 
                    <img id="logo" src="bayern_munich.jpg">
                <?php } else if($owner_clubid=='00004') { ?> 
                    <img id="logo" src="chelsea.jpg">
                <?php } ?>
                    <h1 class="request_header">Request Table</h1>
                
                <table class="request_table">
                    <thead class="table_head">
                      <tr>
                        <th style="padding-left:3%;display: none;">ID</th>
                        <th style="display: none;">Type</th>      
                        <th>Name</th>
                        <th>Age</th>     
                        <th>Country</th>      
                        <th>Mail</th>
                        <th>History</th>
                        <th>Approve/Decline</th>      
                      </tr>
                    </thead>
                    <tbody class="table_body">   
                        <?php
                        while($row = $result->fetch_assoc())
                        {
                        ?>
                        <tr>
                          <td style="padding-left: 3%;display: none;"><?php echo $row['id']; $temp_id=$row['id'] ?></td>
                          <td style="display: none;"><?php echo $row['type']; ?></td>
                          <td><?php echo $row['name']; ?></td>

                            <?php
                                $dob= new DateTime($row['DOB']);
                                $age= $dob->diff(new DateTime);
                            ?>

                          <td><?php echo $age->y; ?></td>
                          <td><?php echo $row['country']; ?></td>
                          <td><?php echo $row['mail']; ?></td>
                          <td>
                              <button id="history_button" class="glass" type="button" onclick="document.getElementById('history').style.display='block'" name="history" value="History">History</button>
                              
                                <div>
                                    <div id="history" class="modal">
                                        <form class="modal-content animate" >
                                            <div class="container_animate">
                                                <div class="details_panel">
                                                    <table class="history_table">
                                                        <h1 class="history_header">History</h1>
                                                        <!--<thead class="table_head">-->
                                                          <?php
                                                            $query3 = "SELECT club.name as club,manager_history.joining_date,manager_history.leave_date
                                                            FROM manager_history JOIN person JOIN club
                                                            ON
                                                            (
                                                                person.id=manager_history.manager_id AND
                                                                club.club_id=manager_history.club_id AND
                                                                person.id='$temp_id'
                                                            )";
                                                            $result1=mysqli_query($conn,$query3);
                                                            ?>
                                                            <thead class="history_table_head">
                                                                <tr>

                                                                    <th id="head">Club</th>
                                                                    <th id="head">Joining Date</th>
                                                                    <th id="head">Leaving Date</th>  
                                                                    
                                                                </tr>
                                                            </thead>
                                                            <tbody class="history_table_body">   
                                                            <?php
                                                                while($row = $result1->fetch_assoc())
                                                                {
                                                            ?>
                                                            <tr>

                                                                <td id="column"><?php echo $row['club']; ?></td>
                                                                <td id="column"><?php echo $row['joining_date']; ?></td>
                                                                <td id="column"><?php echo $row['leave_date']; ?></td>
                                                                <td id="column"> </td>
                                                            </tr>
                                                            </tbody>
                                                            <?php
                                                            }
                                                            ?>
                                                        <!--</tbody>-->
                                                    </table>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                          </td>
                          <td>
                              <button id="approve_button" class="glass" type="button" onclick="addme('<?php echo $temp_id; ?>',1)" name="add" value="Approve">Approve</button>
                              <button id="decline_button" class="glass" type="button" onclick="addme('<?php echo $temp_id; ?>',0)" name="add" value="Delete">Decline</button>
                          </td>
                        </tr>

                        <script language="javascript">

                            function addme(userid,command)
                            {                      
                                var username= "<?php echo $loggedUsername; ?>";  
                                var club_manager_salary= "<?php echo $club_manager_salary; ?>";  
                                window.location.href='owner_managerselection.php?userid='+userid+'& username='+username+'& command='+command+'& club_manager_salary='+club_manager_salary+'';

                            } 
                        </script>


                        <?php
                        }
                        ?>
                   </tbody>

                   <?php $conn->close() ;?>

                </table>
            </div>
            
        </div>

        <!------------------>

    
    <!-- /.container -->

    <div class="container">

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12" style="color: black">
                    <p>Copyright &copy; Fifa World</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <script>
    // Get the modal
    var modal = document.getElementById('history');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) 
    {
        if (event.target == modal) 
        {
            modal.style.display = "none";
        }
    }
    </script>

</body>

</html>