<?php

    include("connect.php");

    $loggedUsername=$_GET['username'];

    $query0= "SELECT club.club_id 
                 FROM club JOIN manager
                 WHERE club.club_id=manager.club_id AND
                 manager.manager_id IN
                 (
                     SELECT manager.manager_id 
                     FROM manager NATURAL JOIN person 
                     WHERE manager.manager_id=person.id AND
                     person.username='$loggedUsername'
                 )
                ";

        $result=mysqli_query($conn,$query0);

        while($row = $result->fetch_assoc())
        {
            $club_id= $row['club_id'];
        }


    $query="SELECT manager.club_status
            FROM manager NATURAL JOIN person
            WHERE manager.manager_id=person.id AND
            person.username='$loggedUsername'";
    
    $result=mysqli_query($conn,$query);


    while($row = $result->fetch_assoc())
    {
        $status= $row['club_status'];
    }

    if($status=='available')
    {
        //result is for request
        $query = "SELECT person.id,person.name,club.name as club_name,player.position
                         FROM person JOIN transfer JOIN player JOIN club
                         ON
                         (
                            person.id=player.player_id and 
	                        player.player_id=transfer.player_id
                            
                         )
                          WHERE 
                          club.club_id=transfer.buyer_club_id AND
                        transfer.buyer_club_id!='$club_id'";
        
        $result=mysqli_query($conn,$query);
        
        //result2 is for Pending
        $query1234 = "SELECT person.id,person.name,club.name as club_name,player.position
                         FROM person JOIN transfer JOIN player JOIN club
                         ON
                         (
                            person.id=player.player_id and 
	                        player.player_id=transfer.player_id AND 
                            club.club_id=player.club_id
                         )
                          WHERE 
                        transfer.buyer_club_id='$club_id'";
        
        $result2=mysqli_query($conn,$query1234);
    }
    else if($status=='unavailable')
    {
        $query = "SELECT player.player_id as id,person.name,player.position,club.name as club
            FROM person JOIN player JOIN club
            ON
            (
                person.id=player.player_id AND 
                player.club_id=club.club_id AND
                player.player_id=''
            )";

        $result=mysqli_query($conn,$query);
                             
        $query1234 = "SELECT person.id,person.name,club.name as club_name,player.position
                         FROM person JOIN transfer JOIN player JOIN club
                         ON
                         (
                            person.id=player.player_id and 
	                        player.player_id=transfer.player_id AND 
                            club.club_id=player.club_id
                         )
                          WHERE 
                        transfer.buyer_club_id=''";
        
        $result2=mysqli_query($conn,$query1234);
    }
    
     $query="SELECT club.name FROM club WHERE club.budget= (SELECT MAX(club.budget) FROM club)";
    
    $result99=mysqli_query($conn,$query);

    while($row = $result99->fetch_assoc())
    {
        $popular_club_name= $row['name'];
    }

    $query="SELECT person.name 
            FROM manager JOIN person
            ON person.id=manager_id
            WHERE manager.point=
            (SELECT MAX(manager.point) FROM manager)";

    $result99=mysqli_query($conn,$query);
    
    while($row = $result99->fetch_assoc())
    {
        $popular_manager_name= $row['name'];
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

    <title>Fifa World</title>

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
            background-image: url(background4.jpg );
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
        .navbar-nav.navbar-right .btn { position: relative; z-index: 2; padding: 4px 20px; margin: 10px auto; transition: transform 0.3s; }

        .navbar .navbar-collapse { position: relative; overflow: hidden !important; }
        .navbar .navbar-collapse .navbar-right > li:last-child { padding-left: 22px; }

        .navbar .nav-collapse { position: absolute; z-index: 1; top: 0; left: 0; right: 0; bottom: 0; margin: 0; padding-right: 120px; padding-left: 80px; width: 100%; }
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
        
        .buy_pending_header
        {
            text-align: center;
            padding-top: 20px;
            color: #141414;
            font-family: arial;
            color: white;
            font-size: 30px;
        }
        
        .buy_pending_table
        {
            
            
            margin: auto;
            margin-top: 35px;
            width:90%;
            border-collapse:separate;
            border: solid white 2px;
            border-radius: 10px;
        }
        .buying_request_table
        {
            margin: auto;
            margin-top: 35px;
            width:90%;
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
            font-size: 19px;
            font-family: Segoe UI;
        }

        td, th 
        {
            border: 3px #141414;
            text-align: center;
            padding: 8px;
        }

        .details_button
        {
             
            color: #fff;
            background-color: rgba(255,255,255);
            background-color: rgba(255,255,255,0.15);
            border-radius: 4px;
            border: none;  
        }
        
        /* Other Parts */
        
        .panel
        {
            margin-top: 100px;
            border-width: medium;
            border-color: white;
            background-color: rgba(0,0,0);
            background-color: rgba(0,0,0,0.4);
            color: white;
        }
        
        .panel,.col-md-4,.fa
        {
            border-radius: 15px;
        }
        
        .panel-heading
        {
            border-radius: 8px;
            text-align: center;
            font-family: Segoe UI Light;
        }
        .panel-body1,.panel-body2
        {
            width: 100%;
        }
        
        .panel-default > .panel-heading 
        {
            background-color: rgba(255,255,255);
            background-color: rgba(255,255,255,0.2);
            color: white;
        }
        
        .col-lg-12
        {
            margin-top: 30px;
            font-size: 15px;
            font-family: Segoe UI Semibold;
        }
        
        /*--------------*/
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
            
            background: url(background7.jpg);
            /*background-color: #3498DB;*/
            margin: 0% auto 0% auto; /* 5% from the top, 15% from the bottom and centered */
            border: 1px solid #888;
            width: 50%; /* Could be more or less, depending on screen size */
        }

        /* Add Zoom Animation */
        .animate 
        {
            -webkit-animation: animatezoom 0.5s;
            animation: animatezoom 0.5s
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
        
        
        .details_panel
        {
            height:500px;
            text-align: right;
            color: white;
        }
        .player_pic
        {
            margin-top: 10px;
            width: 40%;
            float: left;
            padding-left: 30px;
            
        }
        
        .transfer_table_table
        {
            margin: auto;
            margin-top: 35px;
            border-collapse:separate;
            border-radius: 20px;
        }
        
        .details_header
        {
            text-align: center;
        }
        
        .details_head
        {
            float: right;
            font-size: 23px;
            font-style: bold;
            color: white;
            font-family: Segoe UI Semibold;
        }
        .details_body
        {
            float: left;
            font-size: 20px;
            color: white;
            font-family: Segoe UI Semibold;
        }
        
        
        /*-----------*/
        
        .edit_button
        {
            font-family: Segoe UI ;
            font-size: 25px;
            margin-top: 20px;
            background-color: rgba(255,255,255);
            background-color: rgba(255,255,255,0.2);
            border-radius: 5px;
            width: 20%;
            height: 40px;
            border: none;
            text-align: center;
            padding-bottom: 5px; 
        }
        
        .response_button
        {
            font-family: Segoe UI ;
            font-size: 25px;
            margin-top: 20px;
            background-color: rgba(255,255,255);
            background-color: rgba(255,255,255,0.2);
            border-radius: 5px;
            width: 20%;
            height: 40px;
            border: none;
            text-align: center;
            padding-bottom: 5px;
        }
        
        
        /*-------------*/
        
        #manager_wrap 
        {
          margin-top: 0.8%; 
          margin-left: 3%;
          width: 5rem;
          height: 5rem;
          border-radius: 2.5rem;
          background-color: rgba(255,255,255);
          background-color: rgba(255,255,255,0.3);
          box-shadow: 1px 3px 10px rgba(0,0,0,.5);
          color: white;
          transition: .4s;
          white-space: nowrap;
          position: absolute;
          overflow: hidden;
          left: 15%;
        }
        #manager_wrap:hover {
          width: 25rem;
          border-radius: 10px;
          box-shadow: 1px 5px 20px rgba(0,0,0,.5);
        }
        #manager_button {
          display: inline-block;
          width: 5rem;
          height: 5rem;
          line-height: 5rem;
          text-align: center;
          border-radius: inherit;
          font-weight: bold;
          cursor: pointer;
          vertical-align: middle;
          transition: .2s;
        }
        #manager_text 
        {
            display: inline-block;
            font-size: 18px;
        }
        
        
        #club_wrap 
        {
          margin-top: 0.8%; 
          margin-left: 3%;
          width: 5rem;
          height: 5rem;
          border-radius: 2.5rem;
          background-color: rgba(255,255,255);
          background-color: rgba(255,255,255,0.3);
          box-shadow: 1px 3px 10px rgba(0,0,0,.5);
          color: white;
          transition: .5s;
          white-space: nowrap;
          position: absolute;
          overflow: hidden;
          right: 14.5%;
        }
        #club_wrap:hover 
        {
          width: 25rem;
          border-radius: 10px;
          box-shadow: 1px 5px 20px rgba(0,0,0,.5);
        }
        #club_button {
          display: inline-block;
          width: 5rem;
          height: 5rem;
          line-height: 5rem;
          text-align: center;
          border-radius: inherit;
          font-size: 2em;
          cursor: pointer;
          vertical-align: middle;
          transition: .5s;
        }
        #club_text 
        {
            display: inline-block;
            font-size: 18px;
            
        }
        
        .flex-container
        {
            display: flex;
            margin-top: 80px;
        }
        
        #head1
        {
            font-size: 25px;
            color: white;
        }
        
        #head2
        {
            position: absolute;
            overflow: hidden;
            right: 2%;
            font-size: 25px;
            color: white;
        }
        
    </style>

</head>

<body>
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="container-fluid">
                <nav class="navbar navbar-inverse">
                      <div class="container">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-3">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                          </button>
                          <a class="navbar-brand" href="main.php? username=<?php echo $loggedUsername?>" style="color:white">FIFA WORLD</a>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="navbar-collapse-3">
                          <ul id="search_panel" class="nav navbar-nav navbar-right">
                            <li><a href="squad.php? username=<?php echo $loggedUsername?>" style="color:white">Squad</a></li>
                            <li><a href="transfer.php? username=<?php echo $loggedUsername?> & budget_alert=0" style="color:white">Transfer</a></li>
                            <li><a href="myclub.php? username=<?php echo $loggedUsername?>" style="color:white">My Club</a></li>
                            <li><a href="profile.php? username=<?php echo $loggedUsername?>" style="color:white">Profile</a></li>
                            <li><a id="logout"  href="index.php" style="color:white">Logout</a></li>
                            <li>
                              <a id="search_button" class="btn btn-default btn-outline btn-circle collapsed"  data-toggle="collapse" href="#nav-collapse3" aria-expanded="false" aria-controls="nav-collapse3" style="background-color:black; font-size: 18px;">Search</a>
                            </li>
                          </ul>
                          <div class="collapse nav navbar-nav nav-collapse slide-down" id="nav-collapse3"style="margin-right:50px">
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
        
        <!-- Slide Part -->

        <div class="row">
            <div  class="col-md-12">

                <div style="border-radius:10px;" id="slide_holder" class="row carousel-holder">

                    <div style="border-radius:10px;" class="col-md-12">
                        
                        <header style="border-radius:10px;" id="myCarousel" class="carousel slide">
                            <ol class="carousel-indicators">
                                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                <li data-target="#myCarousel" data-slide-to="1"></li>
                                <li data-target="#myCarousel" data-slide-to="2"></li>
                                <li data-target="#myCarousel" data-slide-to="3"></li>
                            </ol>

                            <div style="border-radius:10px;" class="carousel-inner">
                                    <div class="item active">
                                        <img style="border-radius:10px;" class="slide-image" src="image1.jpg" alt="">
                                    </div>
                                    <div class="item">
                                        <img style="border-radius:10px;" class="slide-image" src="image2.jpg" alt="">
                                    </div>
                                    <div  class="item">
                                        <img style="border-radius:10px;" class="slide-image" src="image3.jpg" alt="">
                                    </div>
                                    <div class="item">
                                        <img style="border-radius:10px;" class="slide-image" src="image4.jpg" alt="">
                                    </div>
                                </div>
                                <a style="border-radius:10px;" class="left carousel-control" href="#myCarousel" data-slide="prev">
                                <span class="icon-prev"></span>
                                </a>
                                <a style="border-radius:10px;" class="right carousel-control" href="#myCarousel" data-slide="next">
                                    <span class="icon-next"></span>
                                </a>
                            </div>
                        </header>
                    </div>
                
        <!------------------>
                
                
                <div class="flex-container">
                    <h3 id="head1" >Best Manager</h3>
                    <div id="manager_wrap" class="expand-wrap">
                    <div id="manager_button" role="button" class="expand-btn"></div>
                    <span id="manager_text" class="expand-text"><?php echo $popular_manager_name ?></span>
                    </div>
                    
                    <h3 id="head2" >Best Club</h3>
                    <div id="club_wrap" class="expand-wrap">
                    <div id="club_button" role="button" class="expand-btn"></div>
                    <span id="club_text" class="expand-text"><?php echo $popular_club_name ?></span>
                    </div>
                </div>
                
                <!-- Other Part -->

                <div class="row">
                    <div class="col-md-12">
                        <div id="panel-default" class="panel panel-default">
                            <div class="panel-heading">
                                <h1 style="padding-bottom:15px;font-size:50px;">Player Buy Pending</h1>
                            </div>
                            <div class="panel-body1">
                               
                                <table id="table" class="buy_pending_table">
                                    <thead class="table_head">
                                      <tr>
                                        <th  style="display: none;">ID</th>     
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Club</th>
                                        <th>Information</th>
                                       <!-- <th>Swap</th>-->      
                                      </tr>
                                    </thead>
                                    <tbody class="table_body">   
                                        <?php
                                        while($row = $result2->fetch_assoc())
                                        {
                                        ?>
                                        <tr>
                                          <td  style="display: none;"><?php echo $row['id']; $tempid=$row['id']; ?></td>
                                          <td><?php echo $row['name']; ?></td>
                                          <td><?php echo $row['position']; ?></td>
                                          <td><?php echo $row['club_name']; ?></td>
                                          <td>
                                              <button class="details_button" onclick="detail('<?php echo $tempid ?>')" style="width:auto;">Details</button>
                                              
                                          </td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                   </tbody>
                                </table>
                                
                                <div align="center">
                                <button class="edit_button" onclick="goto('<?php echo $loggedUsername ?>')">
                                    Edit</button>
                                    <script language="javascript">
                                        function goto(username)
                                        {
                                            window.location.href='transfer.php?username='+username+'& budget_alert='+0+'';
                                        }
                                    </script>
                                    
                                    
                                </div>
                                
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h1 style="padding-bottom:15px;font-size:50px;">Player Buying Request</h1>
                            </div>
                            <div class="panel-body">
                                <div class="panel-body2">
                               
                                <table id="table" class="buying_request_table">
                                    <thead class="table_head">
                                      <tr>
                                        <th  style="display: none;">ID</th>     
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Club</th>
                                        <th>Information</th>
                                       <!-- <th>Swap</th>-->      
                                      </tr>
                                    </thead>
                                    <tbody class="table_body">   
                                        <?php
                                        
                                        while($row = $result->fetch_assoc())
                                        {
                                        ?>
                                        <tr>
                                          <td  style="display: none;"><?php echo $row['id']; $tempid=$row['id']; ?></td>
                                          <td><?php echo $row['name']; ?></td>
                                          <td><?php echo $row['position']; ?></td>
                                          <td><?php echo $row['club_name']; ?></td>
                                          <td>
                                              <button class="details_button" onclick="detail('<?php echo $tempid ?>')" style="width:auto;">Details</button>
                                              
                                              <script language="javascript">
                    

                                                    function detail(playerid)
                                                    {   
                                                        var username= '<?php echo $loggedUsername ?>';


                                                        window.location.href='detail.php?username='+username+'& playerid='+playerid+'';

                                                    } 
                                                    </script>
                                          </td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                   </tbody>

                                   <?php $conn->close() ;?>

                                </table>
                            
                                <div align="center">
                                <button class="response_button" onclick="goto('<?php echo $loggedUsername ?>')">Response</button>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                
               <!------------------> 
                
            </div>
        </div>
    </div>
</div>
<!------------------>

    
    <!-- /.container -->

    <div class="container">

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12" style="color:white">
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
        
        Array.prototype.forEach.call(document.querySelectorAll('.expand-btn'), function(btn) {
        btn.addEventListener('click', function() {
        btn.parentNode.classList.toggle('expanded');
        })});
            
    </script>



    <script>
    // Get the modal
    var modal = document.getElementById('details');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) 
    {
        if (event.target == modal) 
        {
            modal.style.display = "none";
        }
    }
    </script>
    
    <script>
    $('.carousel').carousel({
        interval: 2000 //changes the speed
    })
    </script>

    <script>
        var status = <?php echo $status ?>;

        if(status == "unavailable")
        {
            $('#panel-default').hide();
        }
        else
        {
            $('#panel-default').show();
        }
    
    </script>

</body>

</html>



