<?php

    include("connect.php");

    $loggedUsername=$_GET['username'];
    $playerid=$_GET['playerid'];
   
    $query= "SELECT t2.name,t1.position,t1.transfer_price FROM
                (
                    SELECT player_id AS id,position,transfer_price
                    FROM player
                    WHERE player.player_id='$playerid'
                ) as t1

                JOIN

                (
                    SELECT person.name,person.id
                    FROM person
                    WHERE person.type='Player'
                ) as t2
                WHERE t1.id=t2.id
                ";

        $result=mysqli_query($conn,$query);

       
    if(isset($_POST['Sell']))
    {
        if(isset($_POST['uprice']))
        {
            $updatedtransferPrice=$_POST["uprice"];
            
            $sql= "UPDATE player SET transfer_price= '$updatedtransferPrice',max_bidding_price='$updatedtransferPrice', transfer_status='available' WHERE player_id = '$playerid'";
           
            $query = mysqli_query($conn, $sql);
            
            header ("Location: myclub.php? username=$loggedUsername");

            $conn->close();
            
            

        }
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

    <title>My Club: Sell Player</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/shop-homepage.css" rel="stylesheet">
    
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

    <style>
    
        
        body
        {
           /*background-image: url(background6.jpg );*/
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


        .header
        {
            text-align: center;
            padding-top: 20px;
            color: #141414;
            font-family: arial; 
        }
        
        #form
        {
            border-radius: 30px;
            /*background-color: rgba(0,0,0,0.8);*/
            background: linear-gradient(#000000,#434343);
            box-shadow: inset -5px -5px rgba(0,0,0,0.4); 
        }
        
        #name,#position,#cprice
        {
            padding-top: 20px;
            font-size: 20px;
            color: white;
        }
        
        
        
        #button
        {
            padding: 10px;
            border: none;
            position: relative;
            display: inline-block;
            background: linear-gradient(#e52d27,#b31217);

            border-radius: 5px;
            color: #fff;
            font-size: 18px;
            font-weight: 600;
            border: none;
        }
        #button:after
        {
            content: '';
            position: absolute;
            top: 1px;
            left: 2px;
            border-radius: 12px;
            width: calc(100% - 4px);
            height: 50%;
            background: linear-gradient(rgba(255,255,255,0.8), rgba(255,255,255,0.2));
        }
        #button:hover 
        {
            color: white;
            opacity: 0.8;
        }
        
        
        #name,#position,#cprice,#uprice
        {
            width: 60%;
            display: block;
            margin: 0 auto;
            border-radius: 15px;
        }
        
        #button
        {
            width: 30%;
            display: block;
            margin: 0 auto;
            border-radius: 13px;
        }
        
        #uprice
        {
            padding-left: 30px; 
            font-size: 18px;
        }
        
        
        

        .effect
        {
            position:relative;
            -webkit-box-shadow:0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
               -moz-box-shadow:0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
                    box-shadow:0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
        }
        .effect:before, .effect:after
        {
            content:"";
            position:absolute;
            z-index:-1;
            -webkit-box-shadow:0 0 20px rgba(0,0,0,0.8);
            -moz-box-shadow:0 0 20px rgba(0,0,0,0.8);
            box-shadow:0 0 20px rgba(0,0,0,0.8);
            top:10px;
            bottom:10px;
            left:0;
            right:0;
            -moz-border-radius:100px / 10px;
            border-radius:100px / 10px;
        }
        .effect:after
        {
            right:10px;
            left:auto;
            -webkit-transform:skew(8deg) rotate(3deg);
               -moz-transform:skew(8deg) rotate(3deg);
                -ms-transform:skew(8deg) rotate(3deg);
                 -o-transform:skew(8deg) rotate(3deg);
                    transform:skew(8deg) rotate(3deg);
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
                            <li><a href="transfer.php?username=<?php echo $loggedUsername ?> & budget_alert=0" style="color:white">Transfer</a></li>
                            <li><a href="myclub.php?username=<?php echo $loggedUsername ?>" style="color:white">My Club</a></li>
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

        <!-- Panel Part -->

        <div>
            <h1 class="header">Sell Player</h1>
            <hr>
            <div class="row">
                
                <div class="col-md-3"></div>
                <div class="col-md-6">
                
                    <form id="form" class="box effect" method="post">
                        
                        <br>
                        <?php while($row = $result->fetch_assoc()) 
                        {    
                        ?>
                        <label id="name">Name : <?php echo $row['name']; ?></label>
                        <label id="position">Postion : <?php echo $row['position']; ?></label>
                        <label id="cprice">Current Price : $<?php echo $row['transfer_price']; ?></label>
                        
                        <?php } ?>
                        <br>
                        <input name='uprice' id="uprice" class="form-control" placeholder="Update Transfer Price" autofocus required>
                        <br>
                        <button name="Sell" id="button" class="glass" type="submit" >Sell Player</button>
                        <br><br><br>

                    </form>
                    
                </div>
                <div class="col-md-3"></div>
                
            </div>
        </div>
            
            
        </div>

        <!------------------>

    
    <!-- Footer -->

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
        
    <script type="text/javascript">
            $.fn.swap = function(other) {
                $(this).replaceWith($(other).after($(this).clone(true)));
            };
            $(document).ready(function() {
                $('tr').css('cursor', 'pointer').click(function() {
                    $(this).swap($(this).next());
                });
            });
    </script>
        

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>