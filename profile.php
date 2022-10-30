<?php

    include("connect.php");
    
    $loggedUsername= $_GET['username'];
    
    $query= "SELECT manager.club_status 
            FROM manager NATURAL JOIN person 
            WHERE manager.manager_id=person.id AND person.username='$loggedUsername'";

    $result=mysqli_query($conn,$query);

    while($row = $result->fetch_assoc())
    {
        $club_status= $row['club_status'];
    }
    
    if($club_status=='available')
    {
        $is_manager=1;
        
        $query ="
                SELECT * FROM 
                (
                    SELECT person.name,manager.contract,manager.salary,manager.picture,person.username,person.password
                    FROM manager NATURAL JOIN person
                    WHERE manager.manager_id=person.id AND
                    person.username='$loggedUsername' 
                ) as t1
                JOIN
                (
                    SELECT club.name as club_name FROM club WHERE club.club_id=
                    (
                        SELECT manager.club_id FROM manager WHERE manager.manager_id=
                        (
                            SELECT manager.manager_id
                            FROM person NATURAL JOIN manager
                            WHERE person.id=manager.manager_id AND
                            person.username='$loggedUsername'
                        )
                    )
                ) as t2
                ";
        
        $result=mysqli_query($conn,$query);                                        
    
        while($row = $result->fetch_assoc())
        {
            $user_name          = $row['name'];
            $user_contract      = $row['contract'];
            $user_salary        = $row['salary'];
            $user_picture       = $row['picture'];
            $user_clubname      = $row['club_name'];
            $user_username      = $row['username'];
            $user_password      = $row['password'];
        }
    
    }
    else if($club_status=='unavailable')
    {
        $is_manager=0;
        
        $query=
            "
            SELECT person.name,manager.contract,manager.salary,manager.picture,person.username,person.password,manager.club_id 
            FROM manager NATURAL JOIN person 
            WHERE manager.manager_id=person.id AND person.username='$loggedUsername'
            ";
        
        $result=mysqli_query($conn,$query);  
        
        while($row = $result->fetch_assoc())
        {
            $user_name          = $row['name'];
            $user_contract      = $row['contract'];
            $user_salary        = $row['salary'];
            $user_picture       = $row['picture'];
            $clubid             = $row['club_id'];
            $user_username      = $row['username'];
            $user_password      = $row['password'];
        }
        if($clubid==NULL)
            $user_clubname='';
    }
    
    
if(isset($_POST['search']))
    {
        $text=$_POST['searchbox'];
        header ("Location: search.php?username=$loggedUsername & text=$text");
    }
    
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Fifa World: Profile</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/shop-homepage.css" rel="stylesheet">

    <style >


        body
        {
            /*background-image: url(background4.jpg );*/
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-position: 0 ;
            padding-top:20px;
        }
        
        /*Navigation Part*/
        
        #search_button
        {
            margin-right: 50px;
            position: relative;
            display: inline-block;
            
            background-color: black;
            background: linear-gradient(#000000,#434343);
            color: #fff;
        }
        #search_button:after
        {
            content: '';
            position: absolute;
            top: 0px;
            left: 2px;
            width: calc(100% - 4px);
            height: 50%;
            border-radius: 10px;
            background: linear-gradient(rgba(255,255,255,0.8), rgba(255,255,255,0.2));
        }
        #search_button:hover 
        {
            color: white;
            opacity: 0.8;
        }
        
        #navbar-collapse-3
        {
            margin-right: 20px;
        }
        
        #search_panel
        {
            font-size: 18px;
        }
        
        #logout
        {
            margin-right: 30px;
            position: relative;
            display: inline-block;
            
            background-color: black;
            background: linear-gradient(#1F1C18,#B31217);
            color: #fff;
        }
        #logout:after
        {
            content: '';
            position: absolute;
            top: 0px;
            left: 2px;
            width: calc(100% - 4px);
            height: 50%;
            background: linear-gradient(rgba(255,255,255,0.8), rgba(255,255,255,0.2));
        }
        #logout:hover 
        {
            color: white;
            opacity: 0.8;
        }
        
        .navbar-brand
        {
            font-family: Segoe UI semibold;
            font-size: 30px;
            padding-left: 30px;
            
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
            transition: all 0.5s;
        }
        
        .navbar-brand
        {
          color: #fff;
          -webkit-animation: neon 2s ease-in-out infinite alternate;
          -moz-animation: neon 2s ease-in-out infinite alternate;
          animation: neon 2s ease-in-out infinite alternate;
        }
        
        @-webkit-keyframes neon
        {
            to 
            {
                text-shadow: 0 0 10px #fff, 0 0 20px #fff, 0 0 30px #fff, 0 0 40px #fff, 0 0 70px #fff, 0 0 80px #fff, 0 0 100px #fff, 0 0 150px #fff;
            }
        }
        .navbar-nav.navbar-right .btn 
        { 
            position: relative; z-index: 2; padding: 4px 20px; margin: 10px auto; transition: transform 0.3s; 
        }

        .navbar .navbar-collapse { position: relative; overflow: hidden !important; }
        .navbar .navbar-collapse .navbar-right > li:last-child { padding-left: 22px; }

        .navbar .nav-collapse 
        { 
            position: absolute; z-index: 1; top: 0; left: 0; right: 0; bottom: 0; margin: 0; padding-right: 120px; padding-left: 80px; width: 100%; 
        }
        .navbar.navbar-default .nav-collapse { background-color: #f8f8f8; }
        .navbar.navbar-inverse .nav-collapse { background-color: #222; }
        .navbar .nav-collapse .navbar-form { border-width: 0; box-shadow: none;}
        .nav-collapse>li { float: right; }

        .btn.btn-circle { border-radius: 50px; }
        .btn.btn-outline { background-color: transparent; }

        .navbar-nav.navbar-right .btn:not(.collapsed) 
        {
            color:white;
            border-color: rgb(111, 84, 153);
        }

        .navbar.navbar-default .nav-collapse,
        .navbar.navbar-inverse .nav-collapse {
            height: auto !important;
            transition: transform 0.3s;
            transform: translate(0px,-50px);
        }
        .navbar.navbar-default .nav-collapse.in,
        .navbar.navbar-inverse .nav-collapse.in {
            transform: translate(0px,0px);
        }
        
        

        @media screen and (max-width: 10px) {
            .navbar .navbar-collapse .navbar-right > li:last-child { padding-left: 15px; padding-right: 15px; } 

            .navbar .nav-collapse { margin: 7.5px auto; padding: 0; }
            .navbar .nav-collapse .navbar-form { margin: 0;}
            .nav-collapse>li { float: none; }

            .navbar.navbar-default .nav-collapse,
            .navbar.navbar-inverse .nav-collapse {
                transform: translate(-100%,0px);
            }
            .navbar.navbar-default .nav-collapse.in,
            .navbar.navbar-inverse .nav-collapse.in {
                transform: translate(0px,0px);
            }

            .navbar.navbar-default .nav-collapse.slide-down,
            .navbar.navbar-inverse .nav-collapse.slide-down {
                transform: translate(0px,-100%);
            }
            .navbar.navbar-default .nav-collapse.in.slide-down,
            .navbar.navbar-inverse .nav-collapse.in.slide-down {
                transform: translate(0px,0px);
            }
        }

        
        /*---------------*/

        /* Profile Part */
        
        .profile_header
        {
            color: #141414;
            font-family: Segoe UI Light;
            font-size: 48px; 
        }

        .name_head,.contract_head,.salary_head,.clubname_head,.username_head,.password_head
        {
            font-family: Segoe UI;
            font-size: 20px;
            color: #474747; 
        }

        .name_box,.contract_box,.salary_box,.clubname_box,.username_box,.password_box
        {
            height: 40px;
            padding-top: 7px;
            padding-left: 20px;
            background-color: #D3D3D3;
            font-family: Segoe UI;
            font-size: 18px;
            color: #474747;      
        }
        /*---------*/
        
        #club_button
        {
            <?php
                if($is_manager==0)
                {?>
                    display: inline-block;
            <?php
                }
                else if($is_manager==1)
                {?>
                   display: none;
            <?php
                }
            ?>
            
            position: relative;
            padding: 10px 20px;
            background-color: blue;
            background: linear-gradient(#000000,#434343);
            border-radius: 5px;
            color: #fff;
            font-family: Segoe UI;
            font-size: 18px;
            font-weight: 600;
            text-decoration: none !important;
            border: none;
        }
        #club_button:after
        {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: calc(100% - 4px);
            height: 50%;
            border-radius: 10px;
            background: linear-gradient(rgba(255,255,255,0.8), rgba(255,255,255,0.2));
        }
        
        #club_button:hover 
        {
            color: white;
            opacity: 0.8;
        }
        
        #leave_button
        {
            <?php
                if($is_manager==1)
                {?>
                    display: inline-block;
            <?php
                }
                else if($is_manager==0)
                {?>
                   display: none;
            <?php
                }
            ?>
            
            position: relative;
            padding: 10px 20px;
            background-color: blue;
            background: linear-gradient(#e52d27,#b31217);
            border-radius: 5px;
            color: #fff;
            font-family: Segoe UI;
            font-size: 18px;
            font-weight: 600;
            text-decoration: none !important;
            border: none;
        }
        #leave_button:after
        {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: calc(100% - 4px);
            height: 50%;
            border-radius: 10px;
            background: linear-gradient(rgba(255,255,255,0.8), rgba(255,255,255,0.2));
        }
        
        #leave_button:hover 
        {
            color: white;
            opacity: 0.8;
        }


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
            background-color: #fefefe;
            margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
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

        .club_list_header
        {
            text-align: center;
            font-family: arial;

        }

        .request_header
        {
            text-align: center;
            padding-top: 20px;
            color: #141414;
            font-family: arial; 
        }
        
        .request_table
        {
            margin: auto;
            margin-top: 35px;
            width:100%;
            border-collapse:separate;
            border: solid #141414 2px;
            border-radius: 20px;
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

        .req_approve_button
        {
             
            color: #fff;
            background-color: #4CAF50;
            border-radius: 4px;
            border: none;
            border-bottom: 4px solid #22A358;   
        }


        /*-------------*/


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
        
        .warning
        {
            /* <?php
                if($is_manager==0)
                { ?> */
                    /* display: inline-block; */
            /* <?php
                }
                else if($is_manager==1)
                { ?> */
                   /* display: none; */
            /* <?php
                }
            ?> */
            
            padding-top: 5px;
            font-size: 18px;
            color: #D8000C;
            background-color: #FFBABA;
            text-align: center;
            border-radius: 10px;
        }
        

    </style>

</head>
        
    </style>

</head>

<body>

    <!-- Navigation -->
    <div class="container">
        <div class="row">
            <div class="container-fluid">
                 <nav class="navbar navbar-inverse">
                    <div class="container">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-3">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="main.php? username=<?php echo $loggedUsername?>" style="color:white">FIFA WORLD</a>
                        </div>

                        <div class="collapse navbar-collapse" id="navbar-collapse-3">
                            <ul id="search_panel" class="nav navbar-nav navbar-right">
                            <li><a href="squad.php?username=<?php echo $loggedUsername ?>" style="color:white">Squad</a></li>
                            <li><a href="transfer.php? username=<?php echo $loggedUsername?> & budget_alert=0" style="color:white">Transfer</a></li>
                            <li><a href="myclub.php? username=<?php echo $loggedUsername?>" style="color:white">My Club</a></li>
                            <li><a href="profile.php? username=<?php echo $loggedUsername?>"  style="color:white">Profile</a>
                            <li><a id="logout"  href="index.php" style="color:white">Logout</a></li>
                            </li>
                            
                            <li>
                                <a id="search_button" class="btn btn-default btn-outline btn-circle collapsed"  data-toggle="collapse" href="#nav-collapse3" aria-expanded="false" aria-controls="nav-collapse3" style="background-color:black; font-size: 18px;">Search</a>
                            </li>
                            </ul>
                        <div class="collapse nav navbar-nav nav-collapse slide-down" id="nav-collapse3" style="margin-right:50px">
                            <form class="navbar-form" role="search" method="post" >
                              <div class="form-group">
                                <input name="searchbox" type="text" class="form-control" style="font-size:18px;" placeholder="Search..." />
                              </div>
                              
                                <button name="search" type="submit" class="btn btn-danger" action="" method="post"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>  
                            </form>
                          </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        
        
        <!-- Profile -->

        
        
        <div class="col-md-4">
                <?php
                if($is_manager==0)
                {
                    echo '<div class="warning">
                    <label>You Need To Join A Club To Use Club Services...!!</label>
                </div>';
                } ?>
                <h1 class="profile_header">Profile</h1>
                <br>
                <div>
                    <a id="club_button" href="x24.php? username=<?php echo $loggedUsername ?> &loginpass=1" class="glass" style="width:auto;">Choose Club</a>
                </div>
                <br>

                
                    <div class="info_container">
                        <div class="ID">
                            <div class="name_head"><p>Name</p></div>
                                <div class="name_box">
                                    <p>
                                        <?php
                                            echo $user_name;
                                        ?>
                                    </p>
                                </div>
                            <div class="contract_head"><p>Contract</p></div>
                                <div class="contract_box">
                                    <p>
                                        <?php
                                            echo $user_contract;
                                        ?>
                                    </p>
                                </div>
                            <div class="salary_head"><p>Salary</p></div>
                                <div class="salary_box">
                                    <p> $
                                        <?php
                                            echo $user_salary;
                                        ?>
                                    </p>
                                </div>
                             <div class="clubname_head"><p>Club</p></div>
                                    <div class="clubname_box">
                                        <p>
                                            <?php
                                            
                                                echo $user_clubname;
                                            ?>
                                        </p>
                                    </div>    
                                <div class="username_head"><p>Username</p></div>
                                    <div class="username_box">
                                        <p>
                                            <?php
                                                echo $user_username;
                                            ?>
                                        </p>
                                    </div>
                                <div class="password_head"><p>Password</p></div>
                                    <div class="password_box">
                                        <p>
                                            <?php
                                               echo $user_password;
                                            ?>
                                        </p>
                                    </div>
                        </div>
                    </div>
                
                <br>
                <br>
                    <div>
                        <a id="leave_button" href="leave_club.php? username=<?php echo $loggedUsername?>"  class="glass" style="width:auto;">Leave Club</a>
                    </div>
                <br>
                
            </div>
        <div class="col-md-1"></div>
        <div class="col-md-6">

            
        </div>
        
        <?php $conn->close() ;?>
                    
        

        <!-- Footer -->
        <div class="col-lg-12">
            <br>
            <p>Copyright &copy; FIFA WORLD</p>
            <br>
        </div>
                
            </div>
        </div>
    </div>
    <!-- container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Script to Activate the Carousel -->
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    </script>

    <script>
    // Get the modal
    var modal = document.getElementById('table');

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