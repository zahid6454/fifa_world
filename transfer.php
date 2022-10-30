<?php

    include("connect.php");

    $loggedUsername=$_GET['username'];
    $budget_alert=$_GET['budget_alert'];

    

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
        
        
        $query_budget="SELECT club.budget 
            FROM club JOIN person JOIN manager
            ON
            (
                manager.club_id=club.club_id AND
                manager.manager_id=person.id AND
                person.username='$loggedUsername'
            )";


        $result_budget=mysqli_query($conn,$query_budget);


        while($row = $result_budget->fetch_assoc())
        {
            $club_budget= $row['budget'];
        }

        
        
        
        
        
        

        $query = "SELECT player.player_id as ID,person.picture,person.name,person.DOB as DOB,person.country,club.name as Club,player.position,player.transfer_price as price 
                  FROM person JOIN player JOIN club ON 
                  ( 
                    (
                        person.id = player.player_id AND
                        player.club_id=club.club_id AND
						player.club_id!='$club_id'
                    ) 
                ) 
                WHERE ( player.transfer_status='available' )";

        $query2 = "SELECT budget FROM club WHERE ( club_id='$club_id' )";
        
        
        $cart=0;
        $query_cart="SELECT SUM(transfer.transfer_price) as cart,transfer.buyer_club_id 
                        FROM transfer
                        WHERE transfer.buyer_club_id='$club_id'
                        GROUP BY transfer.buyer_club_id
                        ";
        
        $result_cart=mysqli_query($conn,$query_cart);

        while($row = $result_cart->fetch_assoc())
        {
            $cart= $row['cart'];
        }
        
        if($cart=== null)
        {
            $cart=0;
        }
        
        
        
        

    }
    else
    {
        header ("Location: profile.php?username=$loggedUsername");
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

    <title>Fifa World: Transfer</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/shop-homepage.css" rel="stylesheet">
    
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <style>
    
        
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

        
        #navbar-collapse-3
        {
            margin-right: 20px;
        }
        
        #search_panel
        {
            font-size: 18px;
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


        /* Table Part */
        
        .transfer_header,.buy_pending_header,.request_accept_header
        {
            text-align: center;
            padding-top: 20px;
            color: #141414;
            font-family: arial;
            font-size: 50px;
        }
        
        .transfer_table,.buy_pending_table,.request_accept_table
        {
            margin: auto;
            margin-top: 35px;
            width:100%;
            border-collapse:separate;
            border: solid #141414 2px;
            border-radius: 4px;
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
            font-size: 18px;
            font-family: Segoe UI;
        }

        td, th 
        {
            border: 3px #141414;
            text-align: center;
            padding: 8px;
        }

        /*tr:hover
        {
            background-color: #66CC75; 
            color:white;
            
        }*/

        
        #details_button
        {
            position: relative;
            display: inline-block;
            padding: 6px 12px;
            background-color: green;
            background: linear-gradient(#00c6ff,#0072ff);
            /* cancel background: linear-gradient(#e52d27,#b31217);*/
            /*sell background: linear-gradient(#fe8c00,#f83600);*/
           /*blue background: linear-gradient(#00c6ff,#0072ff);*/

            border-radius: 5px;
            color: #fff;
            font-size: 18px;
            font-weight: 600;
            border: none;
        }
        #details_button:after
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
        #details_button:hover 
        {
            color: white;
            opacity: 0.8;
        }
        
        
        #request_button
        {
            position: relative;
            display: inline-block;
            padding: 6px 12px;
            
            background: linear-gradient(#8b54f2,#2a0845);
            /* cancel background: linear-gradient(#e52d27,#b31217);*/
            /*sell background: linear-gradient(#fe8c00,#f83600);*/
           /*blue background: linear-gradient(#00c6ff,#0072ff);*/

            border-radius: 5px;
            color: #fff;
            font-size: 18px;
            font-weight: 600;
            border: none;
        }
        #request_button:after
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
        #request_button:hover 
        {
            color: white;
            opacity: 0.8;
        }
        
        
        #update_button
        {
            position: relative;
            display: inline-block;
            padding: 6px 12px;
            background: linear-gradient(#073,#0fa);
            /* cancel background: linear-gradient(#e52d27,#b31217);*/
            /*sell background: linear-gradient(#fe8c00,#f83600);*/
           /*blue background: linear-gradient(#00c6ff,#0072ff);*/

            border-radius: 5px;
            color: #fff;
            font-size: 18px;
            font-weight: 600;
            border: none;
        }
        #update_button:after
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
        #update_button:hover 
        {
            color: white;
            opacity: 0.8;
        }
        
        
         #cancel_button
        {
            position: relative;
            display: inline-block;
            padding: 6px 12px;
            background: linear-gradient(#e52d27,#b31217);
            /* cancel background: linear-gradient(#e52d27,#b31217);*/
            /*sell background: linear-gradient(#fe8c00,#f83600);*/
           /*blue background: linear-gradient(#00c6ff,#0072ff);*/

            border-radius: 5px;
            color: #fff;
            font-size: 18px;
            font-weight: 600;
            border: none;
        }
        #cancel_button:after
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
        #cancel_button:hover 
        {
            color: white;
            opacity: 0.8;
        }
        
        
        
        
        #accept_button
        {
            position: relative;
            display: inline-block;
            padding: 6px 12px;
            background: linear-gradient(#3c9125,#52c234);
            /* cancel background: linear-gradient(#e52d27,#b31217);*/
            /*sell background: linear-gradient(#fe8c00,#f83600);*/
           /*blue background: linear-gradient(#00c6ff,#0072ff);*/

            border-radius: 5px;
            color: #fff;
            font-size: 18px;
            font-weight: 600;
            border: none;
        }
        #accept_button:after
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
        #accept_button:hover 
        {
            color: white;
            opacity: 0.8;
        }
        
        
         #reject_button
        {
            position: relative;
            display: inline-block;
            padding: 6px 12px;
            background: linear-gradient(#e52d27,#b31217);
            /* cancel background: linear-gradient(#e52d27,#b31217);*/
            /*sell background: linear-gradient(#fe8c00,#f83600);*/
           /*blue background: linear-gradient(#00c6ff,#0072ff);*/

            border-radius: 5px;
            color: #fff;
            font-size: 18px;
            font-weight: 600;
            border: none;
        }
        #reject_button:after
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
        #reject_button:hover 
        {
            color: white;
            opacity: 0.8;
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
            
            background: url(background7.jpg);
            /*background-color: #3498DB;*/
            margin: 0% auto 0% auto; /* 5% from the top, 15% from the bottom and centered */
            border: 1px solid #888;
            width: 50%; /* Could be more or less, depending on screen size */
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
        
        .details_header
        {
            text-align: center;
        }
        
        .budget_label
        {
            font-size: 30px;
            text-align: center;
            color: #4CAF50;
        }
        
        .cart_label
        {
            font-size: 30px;
            text-align: center;
            color: darkorange;
        }
        
        .error_balance_label
        {
            <?php if($budget_alert==1)
            { ?>
                display: block;
            <?php } else 
            {?>
                display: none;
            <?php }?>
            
            font-size: 30px;
            text-align: center;
            color: #F00000;
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

        
        
    
    </style>
    
</head>

<body>
    
    <p id="demo"></p>
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
                          <a class="navbar-brand" href="main.php?username=<?php echo $loggedUsername ?>" style="color:white">FIFA WORLD</a>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="navbar-collapse-3">
                          <ul id="search_panel" class="nav navbar-nav navbar-right">
                            <li><a href="squad.php?username=<?php echo $loggedUsername ?>" style="color:white">Squad</a></li>
                            <li><a href="transfer.php? username=<?php echo $loggedUsername?> & budget_alert=0" style="color:white">Transfer</a></li>
                            <li><a href="myclub.php? username=<?php echo $loggedUsername?>" style="color:white">My Club</a></li>
                            <li><a href="profile.php? username=<?php echo $loggedUsername?>"  style="color:white">Profile</a></li>
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
        
        <!------------------>

        <!-- Table Part -->

        <div>
            
        <h1 class="transfer_header">Transfer Table</h1>
            
        
        <form>

            <h1 class="budget_label">BUDGET : $<?php echo $club_budget; ?></h1>
            <h1 class="cart_label">CART : $<?php echo $cart; ?></h1>
            <h1 class="error_balance_label">INSUFFICIENT BALANCE</h1>
            
        </form>
    
        <table id="table" class="transfer_table">
            <thead class="table_head">
              <tr>
                <th style="display: none;">ID</th>
                <th style="width:10%;">Picture</th>
                <th>Name</th>
                <th>Country</th>     
                <th>Age</th>
                <th>Club</th> 
                <th>Position</th>
                <th>Price</th>
                <th>Details</th>     
                <th>Request</th>     
              </tr>
            </thead>
            <tbody class="table_body">   
                <?php
                

                $result=mysqli_query($conn,$query);
                while($row = $result->fetch_assoc())
                {
                ?>
                <tr>
                  <td style="display: none;"><?php echo $row['ID']; $tempid=$row['ID'];?></td>
                  <td><img src="<?php echo $row['picture']; ?>" style="width:80%;border-radius:10px;"></td>     
                  <td><?php echo $row['name']; ?></td>
                  <td><?php echo $row['country']; ?></td>
                    
                  <?php
                    $dob= new DateTime($row['DOB']);
                    $age= $dob->diff(new DateTime);
                  ?>
                    
                  <td><?php echo $age->y; ?></td>    
                  <td><?php echo $row['Club']; ?></td>
                  <td><?php echo $row['position']; ?></td>
                  <td>$<?php echo $row['price']; $tempPrice=$row['price'];?></td>
                  <td><button id="details_button" class="glass" onclick="detail('<?php echo $tempid; ?>')"  style="width:auto;">Details</button>  
                </td>
                <td>
                    <button id="request_button" class="glass" onclick="request('<?php echo $tempid; ?>','<?php echo $tempPrice; ?>',1)" style="width:auto;">Request</button>
                </td>

                <p id="demo"></p>

                <script language="javascript">
                    

                    function request(playerid,price,command)
                    {   
                       
                        var budget= '<?php echo $club_budget ?>';
                        var cart= '<?php echo $cart ?>';
                        
                        
                        var username= '<?php echo $loggedUsername ?>';
                        var club_id= '<?php echo $club_id ?>';
                        
                       
                        if(command==0)
                        {
                            window.location.href='transfer_work.php?username='+username+'& playerid='+playerid+'& club_id='+club_id+'& command='+command+'& price='+price+'';
                        }
                        else
                        {
                            var available=budget-cart;
                            
                            if((available >= price) && (available >= 10000))
                            {
                                if(command==2)
                                {
                                   window.location.href='bidding_price.php?username='+username+'& playerid='+playerid+'& club_id='+club_id+'';
                                }
                                else
                                {
                                    window.location.href='transfer_work.php?username='+username+'& playerid='+playerid+'& club_id='+club_id+'& command='+command+'& price='+price+'';
                                }
                            }
                            else
                            {
                                window.location.href='transfer.php?username='+username+'& budget_alert='+1+'';
                            }
                        
                        }
                    }
                         
                </script> 
                    
                </tr>
                <?php
                }
                ?>
           </tbody>
            
                
        </table>

        


        <br>
        <br>
        <br>
        <br>


        <h1 class="buy_pending_header">Buy Pending Table</h1>
            


        <table id="table" class="buy_pending_table">
            <thead class="table_head">
              <tr>
                <th style="display: none;">ID</th>
                <th style="width:5%;">Picture</th>   
                <th style="width:5%;">Name</th>    
                <th style="width:5%;">Age</th>
                <th style="width:5%;">Club</th> 
                <th style="width:5%;">Position</th>
                <th style="width:5%;">Price</th>
                <th style="width:5%;">Highest Bid</th>
                <th style="width:5%;">No. of Highest Bidder</th>
                <th style="width:5%;">Details</th>     
                <th style="width:5%;">Update/Cancel</th>     
              </tr>
            </thead>
            <tbody class="table_body">   
                <?php
                
                $query4="SELECT * FROM
                        (
                            SELECT person.id,person.picture,person.name,person.DOB,club.name as club_name,player.position,player.max_bidding_price,transfer.transfer_price
                                                 FROM person JOIN transfer JOIN player JOIN club
                                                 ON
                                                 (
                                                    transfer.player_id=person.id AND
                                                    player.player_id=person.id AND
                                                    club.club_id=
                                                    (
                                                        SELECT player.club_id WHERE player.player_id=transfer.player_id
                                                    ) AND
                                                    transfer.buyer_club_id='$club_id'

                                                 )

                        ) AS t1

                        JOIN

                        (
                            SELECT transfer.player_id,COUNT(transfer.player_id) as counted
                            FROM transfer JOIN player
                            ON
                            (
                                transfer.player_id=player.player_id AND
                                transfer.transfer_price=player.max_bidding_price
                            )
                            GROUP BY transfer.player_id

                        ) AS t2
                        WHERE t1.id=t2.player_id";

                $result3=mysqli_query($conn,$query4);
                while($row = $result3->fetch_assoc())
                {
                ?>
                <tr>
                  <td style="display: none;"><?php echo $row['id']; $tempid=$row['id'];?></td>
                  <td><img src="<?php echo $row['picture']; ?>" style="width:80%;border-radius:10px;"></td>  
                  <td><?php echo $row['name']; ?></td>
                  
                    
                  <?php
                    $dob= new DateTime($row['DOB']);
                    $age= $dob->diff(new DateTime);
                  ?>
                    
                  <td><?php echo $age->y; ?></td>    
                  <td><?php echo $row['club_name']; ?></td>
                  <td><?php echo $row['position']; ?></td>
                  <td>$<?php echo $row['transfer_price']; ?></td>
                  <td>$<?php echo $row['max_bidding_price']; ?></td>
                  <td><?php echo $row['counted']; ?></td>
                  <td><button id="details_button" class="glass" onclick="detail('<?php echo $tempid; ?>')" style="width:auto;">Details</button>  
                </td>
                    
        
                    
                    
                <td>
                    <button id="update_button" class="glass" onclick="request('<?php echo $tempid; ?>',0,2)" style="width:auto;">Update</button>
                    <button id="cancel_button" class="glass" onclick="request('<?php echo $tempid; ?>',0,0)" style="width:auto;">Cancel</button>
                </td>

                
                    
                </tr>
                <?php
                }
                ?>
           </tbody>
            
                
        </table>



        <br>
        <br>
        <br>
        <br>


        <h1 class="request_accept_header">Request Accept Table</h1>
            


        <table id="table" class="request_accept_table">
            <thead class="table_head">
              <tr>
                <th style="display: none;">ID</th>
                <th style="width:10%;">Picture</th>  
                <th>Name</th>     
                <th>Age</th> 
                <th>Position</th>
                <th>Price</th>  
                <th>Buyers Club Name</th>
                <th>Details</th>   
                <th>Accept/Reject</th>     
              </tr>
            </thead>
            <tbody class="table_body">   
                <?php
                
                $query5="SELECT person.id,person.picture,person.name,person.DOB,person.country,club.name as club_name,player.position,transfer.transfer_price
                         FROM person JOIN transfer JOIN player JOIN club
                         ON
                         (
	                        transfer.player_id=person.id AND
                            player.player_id=person.id AND
                            player.club_id='$club_id' AND 
                            club.club_id=transfer.buyer_club_id AND
                            transfer.buyer_club_id!='$club_id'
                         )";

                $result2=mysqli_query($conn,$query5);
                while($row = $result2->fetch_assoc())
                {
                ?>
                <tr>
                  <td style="display: none;"><?php echo $row['id']; $tempid=$row['id'];?></td>
                  <td><img src="<?php echo $row['picture']; ?>" style="width:80%;border-radius:10px;"></td>    
                  <td><?php echo $row['name']; ?></td>
                    
                  <?php
                    $dob= new DateTime($row['DOB']);
                    $age= $dob->diff(new DateTime);
                  ?>
                    
                  <td><?php echo $age->y; ?></td>
                  <td><?php echo $row['position']; ?></td>
                  <td>$<?php echo $row['transfer_price']; ?></td>
                    <td><?php echo $row['club_name']; $tempclub=$row['club_name']; ?></td>  
                  <td><button id="details_button" class="glass" onclick="detail('<?php echo $tempid; ?>')" style="width:auto;">Details</button>  
                </td> 
                    
                    <script language="javascript">
                    

                    function detail(playerid)
                    {   
                        var username= '<?php echo $loggedUsername; ?>';
                        
                        
                        window.location.href='detail.php?username='+username+'& playerid='+playerid+'';

                    } 
                    </script>
                    
                    
                    
                <td>
                    <button id="accept_button" class="glass" onclick="addReject('<?php echo $tempid; ?>','<?php echo $tempclub; ?>',1)" style="width:auto;">Accept</button>
                    <button id="reject_button" class="glass" onclick="addReject('<?php echo $tempid; ?>','<?php echo $tempclub; ?>',0)" style="width:auto;">Reject</button>
                    
                    <script language="javascript">
                        
                        function addReject(playerid,clubname,command)
                        {
                            var username= '<?php echo $loggedUsername; ?>';
                            
                            window.location.href='player_accept_reject.php?username='+username+'& playerid='+playerid+'& club_name='+clubname+'& command='+command+'';
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

        
        </div>

        <!------------------>

    
    <!-- /.container -->

    <div class="container">
    
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
        
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
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

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>