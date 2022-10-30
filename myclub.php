<?php

    include("connect.php");


    $loggedUsername= $_GET['username'];

    
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
            $query= "SELECT club.club_id 
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

        $result=mysqli_query($conn,$query);

        while($row = $result->fetch_assoc())
        {
            $club_id= $row['club_id'];
        }



        $query= "SELECT t1.id,t2.picture,t2.name,t1.position,t1.salary,t1.transfer_price FROM
                (
                    SELECT player_id AS id,position,salary,transfer_price
                    FROM player
                    WHERE player.club_id='$club_id'
                          
                ) as t1

                JOIN

                (
                    SELECT person.name,person.id,person.picture
                    FROM person
                    WHERE person.type='Player'
                ) as t2
                WHERE t1.id=t2.id";

        $result=mysqli_query($conn,$query);

    }
    else
    {
        header ("Location: profile.php?username=$loggedUsername &loginpass=1");
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

    <title>Fifa World: My Club</title>

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
        
        .transfer_header
        {
            text-align: center;
            padding-top: 20px;
            color: #141414;
            font-family: arial;
            font-size: 50px;
        }
        
        .myclub_table,.sell_pending_table
        {
            margin: auto;
            margin-top: 35px;
            width:90%;
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
            font-size: 22px;
            font-family: Segoe UI;
        }

        td, th 
        {
            border: 3px #141414;
            text-align: center;
            padding: 8px;
        }

        .glass
        {
            position: relative;
            display: inline-block;
            padding: 6px 12px;
            
            background-color: blue;
            /* cancel background: linear-gradient(#e52d27,#b31217);*/
            /*sell background: linear-gradient(#fe8c00,#f83600);*/
            background: linear-gradient(#00c6ff,#0072ff);

            border-radius: 5px;
            color: #fff;
            font-size: 18px;
            font-weight: 600;
            border: none;
        }
        .glass:after
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
        .glass:hover 
        {
            color: white;
            opacity: 0.8;
        }
        
        .request_button
        {
             
            color: #fff;
            background-color: #7646FF;
            border-radius: 4px;
            border: none;
            border-bottom: 4px solid #310576;   
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

        /*-------------*/
        
        
        #salary_box,#sell_box
        {
            padding-left: 20px;
            font-family: arial;
            font-weight:lighter;
        }
        
        #update
        {
            position: relative;
            display: inline-block;
            padding: 6px 12px;
            background-color: green;
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
        #update:after
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
        #update:hover 
        {
            color: white;
            opacity: 0.8;
        }
        
        #sell
        {
            position: relative;
            display: inline-block;
            padding: 6px 20px;
            background-color: orangered;
            background: linear-gradient(#073,#0fa);
            /* cancel background: linear-gradient(#e52d27,#b31217);*/
            background: linear-gradient(#fe8c00,#f83600);
           /*blue background: linear-gradient(#00c6ff,#0072ff);*/

            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 18px;
            font-weight: 600;  
        }
        #sell:after
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
        #sell:hover 
        {
            color: white;
            opacity: 0.8;
        }
        
        
        #sell_cancel
        {
            position: relative;
            display: inline-block;
            padding: 6px 20px;
            background-color: orangered;
            background: linear-gradient(#e52d27,#b31217);

            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 18px;
            font-weight: 600;  
        }
        #sell_cancel:after
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
        #sell_cancel:hover 
        {
            color: white;
            opacity: 0.8;
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
                          <a class="navbar-brand" href="main.php?username=<?php echo $loggedUsername ?>" style="color:white">FIFA WORLD</a>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="navbar-collapse-3">
                          <ul id="search_panel" class="nav navbar-nav navbar-right">
                            <li><a href="squad.php?username=<?php echo $loggedUsername ?>" style="color:white">Squad</a></li>
                            <li><a href="transfer.php? username=<?php echo $loggedUsername?> & budget_alert=0" style="color:white">Transfer</a></li>
                            <li><a href="myclub.php? username=<?php echo $loggedUsername?>" style="color:white">My Club</a></li>
                            <li><a href="profile.php?username=<?php echo $loggedUsername ?>" style="color:white">Profile</a></li>
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
            
        <h1 class="transfer_header">My Club Table</h1>
        
    
        <table id="table" class="myclub_table">
            <thead class="table_head">
              <tr>
                <th style="display: none;">ID</th>
                <th style="width:10%;">Picture</th>
                <th>Name</th>
                <th>Position</th>     
                <th>Details</th>
                <th>Salary</th>
                <th>Sell</th>    
              </tr>
            </thead>
            <tbody class="table_body">   
                <?php
                
                while($row = $result->fetch_assoc())
                {
                ?>
                <tr>
                  <td style="display: none;"><?php echo $row['id']; $tempid=$row['id'];?></td>
                  <td><img src="<?php echo $row['picture']; ?>" style="width:80%;border-radius:10px;"></td>
                  <td><?php echo $row['name']; ?></td>
                  <td><?php echo $row['position']; $salary=$row['salary'];?></td>
                  <td><button id="#details_button" class="glass" onclick="detail('<?php echo $tempid ?>')" style="width:auto;">Details</button>
                     
                      <script language="javascript">
                    

                    function detail(playerid)
                    {   
                        var username= '<?php echo $loggedUsername ?>';
                        
                        
                        window.location.href='detail.php?username='+username+'& playerid='+playerid+'';

                    } 
                    </script>
                      
                     
                  
                </td>
                <td>
                <from action="myclub.php" method="post">
                    <label id="salary_box" style="width:50%;">$<?php echo $salary; ?></label>
                    
                    <button id="update" name="update" class="glass" onclick="play('<?php echo $tempid; ?>',1)" >Update</button>
                    
                </from>
                </td>
                <p id="demo"></p>

                


                    
                <td>
                    <button id="sell" class="glass" onclick="play('<?php echo $tempid; ?>',0)" >Sell Player</button>
                </td>
                    
                </tr>

                <script language="javascript">
                    

                    function play(playerid,command)
                    {   
                        var username= '<?php echo $loggedUsername ?>';
                        
                        if(command==1)
                            window.location.href='update_salary.php?username='+username+'& playerid='+playerid+'';
                        else if(command==0)
                            window.location.href='sell_player.php?username='+username+'& playerid='+playerid+'';

                    } 
                </script> 
                
                
                    
                
            
                <?php
                }
                ?>
           </tbody>
                
        </table>
        
        <br>
        <br>
        <br>
        <br>
        
        <h1 class="transfer_header">Sell Pending Table</h1>
        
    
        <table id="table" class="sell_pending_table">
            <thead class="table_head">
              <tr>
                <tr>
                <th style="display: none;">ID</th>
                <th style="width:10%;">Picture</th>
                <th>Name</th>
                <th>Position</th>     
                <th>Transfer Price</th>     
                <th>Details</th>
                <th>Sell Cancel</th>    
              </tr>    
              </tr>
            </thead>
            <tbody class="table_body">   
                <?php
                
                $query4="SELECT t1.id,t2.picture,t2.name,t1.position,t1.transfer_price FROM
                (
                    SELECT player_id AS id,position,transfer_price
                    FROM player
                    WHERE player.club_id='$club_id' AND
                          player.transfer_status='available'
                          
                ) as t1

                JOIN

                (
                    SELECT person.name,person.id,person.picture
                    FROM person
                    WHERE person.type='Player'
                ) as t2
                WHERE t1.id=t2.id";
                
                $result=mysqli_query($conn,$query4);
                while($row = $result->fetch_assoc())
                {
                    $id=$row['id'];
                    $name=$row['name'];
                    $position=$row['position'];
                    $tp=$row['transfer_price'];
                    
                    
                ?>
                <tr>
                  <td style="display: none;"><?php echo $row['id']; $tempid=$row['id'];?></td>
                  <td><img src="<?php echo $row['picture']; ?>" style="width:80%;border-radius:10px;"></td>
                  <td><?php echo $row['name']; ?></td>
                  <td><?php echo $row['position']; ?></td>
                  <td>$<?php echo $row['transfer_price']; ?></td>
                  <td><button id="#details_button" class="glass" onclick="detail('<?php echo $tempid ?>')" style="width:auto;">Details</button>
                      
                      
                      <script language="javascript">
                    

                    function detail(playerid)
                    {   
                        var username= '<?php echo $loggedUsername ?>';
                        
                        
                        window.location.href='detail.php?username='+username+'& playerid='+playerid+'';

                    } 
                    </script>
                  
                </td>
                <td>
                    <button id="sell_cancel" class="glass" onclick="sell('<?php echo $tempid; ?>')" >Cancel</button>
                </td>
                    
                </tr>

                <script language="javascript">
                    

                    function sell(playerid)
                    {   
                        var username= '<?php echo $loggedUsername ?>';
                        
                        window.location.href='cancel_sell_player.php?username='+username+'& playerid='+playerid+'';

                    } 
                </script> 
                
                
                    
                
            
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