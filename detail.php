<?php

    include("connect.php");
    
    $loggedUsername=$_GET['username'];
    $playerid=$_GET['playerid'];

    $query= "SELECT person.name,person.picture,player.* 
            FROM player JOIN person
            ON 
            (
                person.id=player.player_id AND
                player.player_id='$playerid'
            )";

    $result=mysqli_query($conn,$query);                                        
    
    while($row = $result->fetch_assoc())
    {   
        $player_picture         = $row['picture'];
        $player_name            = $row['name'];
        $player_position        = $row['position'];
        $player_speed           = $row['speed'];
        $player_passing         = $row['passing'];
        $player_control         = $row['control'];
        $player_power           = $row['power'];
        $player_stamina         = $row['stamina'];
        $player_strength        = $row['strength'];
        $player_jersey           = $row['jersey_no'];
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

    <title>Details</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/shop-homepage.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

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
            text-align: center;
            color: #141414;
            font-family: Segoe UI Light;
            font-size: 48px; 
        }

        .name_head,.position_head,.speed_head,.passing_head,.control_head,.power_head,.stamina_head,.strength_head,.jersey_head
        {
            font-family: Segoe UI;
            font-weight: bolder;
            font-size: 20px;
            color: #474747; 
        }

        .name_box,.position_box,.speed_box,.passing_box,.control_box,.power_box,.stamina_box,.strength_box,.jersey_box
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
        
        #history_button
        {
            position: relative;
            display: block;
            padding: 10px 20px;
            background-color: blue;
            background: linear-gradient(#6f0000,#200122);
            border-radius: 5px;
            color: #fff;
            font-family: Segoe UI;
            font-size: 18px;
            font-weight: 600;
            text-decoration: none !important;
            border: none;
            margin: 0 auto;
        }
        #history_button:after
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
        
        #history_button:hover 
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
        
        .budget_label
        {
            font-size: 30px;
            text-align: center;
            color: #4CAF50;
        }

        /*-------------*/
              
        .col-lg-12
        {
            margin-top: 30px;
            font-size: 15px;
            font-family: Segoe UI Semibold;
        }
        
        /*--------------*/
        
        .transfer_header
        {
            text-align: center;
            padding-top: 20px;
            color: #141414;
            font-family: arial;
            font-size: 50px;
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
        
        .table_head
        {
            color: white;
            font-size: 22px;
            font-family: arial;
        }
        
        .table_body
        {
            color: white;
            font-family: Segoe UI;
        }

        td, th 
        {
            border: 3px white;
            text-align: center;
            padding: 8px;
            color: white;
        }
        td
        {
            font-size: 20px;   
        }
        

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
                            <li><a href="squad.php? username=<?php echo $loggedUsername?>" style="color:white">Squad</a></li>
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
        <div class="col-md-4"></div>
        <div class="col-md-4">
                <h1 class="profile_header">Profile</h1>
                <br>
                <div>
                    <div align="center">
                        <p>
                            <img src="<?php echo $player_picture; ?>" style="border-radius: 15px;">
                        </p>
                    </div>
                    <button id="history_button" class="glass" onclick="document.getElementById('history').style.display='block'" style="width:auto;">History</button>
                    <div>
                        <div id="history" class="modal">
                            <form class="modal-content animate" >
                                <div class="container_animate">
                                    <div class="details_panel">
                                        <table class="history_table">
                                            <h1 class="history_header">History</h1>
                                            <!--<thead class="table_head">-->
                                              <?php
                                                $query3 = "SELECT club.name as club,player_history.joining_date,player_history.leave_date,player_history.transfer_price
                                                FROM player_history JOIN person JOIN club
                                                ON
                                                (
                                                    person.id=player_history.player_id AND
                                                    club.club_id=player_history.club_id AND
                                                    person.id='$playerid'
                                                )";
                                                $result1=mysqli_query($conn,$query3);
                                                ?>
                                                <thead class="table_head">
                                                    <tr>
                                                       
                                                        <th>Club Name</th>
                                                        <th>Joining Date</th>
                                                        <th>Leave Date</th>
                                                        <th>Transfer Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table_body">   
                                                <?php
                                                    while($row = $result1->fetch_assoc())
                                                    {
                                                ?>
                                                <tr>
                                                   
                                                    <td><?php echo $row['club']; ?></td>
                                                    <td><?php echo $row['joining_date']; ?></td>
                                                    <td><?php echo $row['leave_date']; ?></td>
                                                    <td><?php echo $row['transfer_price']; ?></td>
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
                <br>

                
                    <div class="info_container">
                        <div class="ID">
                            <div class="name_head"><p>Name</p></div>
                                <div class="name_box">
                                    <p>
                                        <?php
                                            echo $player_name;
                                        ?>
                                    </p>
                                </div>
                            <div class="position_head"><p>Position</p></div>
                                <div class="position_box">
                                    <p>
                                        <?php
                                            echo $player_position;
                                        ?>
                                    </p>
                                </div>
                            <div class="speed_head"><p>Speed</p></div>
                                <div class="speed_box">
                                    <p>
                                        <?php
                                            echo $player_speed;
                                        ?>
                                    </p>
                                </div>
                            <div class="passing_head"><p>Passing</p></div>
                                <div class="passing_box">
                                    <p>
                                        <?php
                                            echo $player_passing;
                                        ?>
                                    </p>
                                </div>
                            <div class="control_head"><p>Control</p></div>
                                <div class="control_box">
                                    <p>
                                        <?php
                                            echo $player_control;
                                        ?>
                                    </p>
                                </div>
                            <div class="power_head"><p>Power</p></div>
                                <div class="power_box">
                                    <p>
                                        <?php
                                            echo $player_power;
                                        ?>
                                    </p>
                                </div>
                            <div class="stamina_head"><p>Stamina</p></div>
                                <div class="stamina_box">
                                    <p>
                                        <?php
                                            echo $player_stamina;
                                        ?>
                                    </p>
                                </div>
                            <div class="strength_head"><p>Strength</p></div>
                                <div class="strength_box">
                                    <p>
                                        <?php
                                            echo $player_strength;
                                        ?>
                                    </p>
                                </div>
                            <div class="jersey_head"><p>Jersey No</p></div>
                                <div class="jersey_box">
                                    <p>
                                        <?php
                                            echo $player_jersey;
                                        ?>
                                    </p>
                                </div>
                                
                        </div>
                    </div>
                
                <br>
                
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