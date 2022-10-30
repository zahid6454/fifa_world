<?php
    
    include("connect.php");

    $loggedUsername=$_GET['username'];
    $text=$_GET['text'];
  
    //---------------------------------------------------Manager----------------------------------------------------------------------
    $query_manager_info="SELECT * FROM 
    (
        SELECT person.name,person.mail,person.country,club.name as club,
        TIMESTAMPDIFF
        (
            YEAR,
            (SELECT person.DOB),
            CURDATE()
        ) AS age

        FROM
        person JOIN manager JOIN club 
        ON
        (
            person.id=manager.manager_id AND
            club.club_id=manager.club_id AND
            person.type='Manager' 



        )
    )    
    AS t1
    WHERE
    (
        t1.name LIKE '%$text%' OR
        t1.mail LIKE '%$text%' OR
        t1.country LIKE '%$text%' OR
        t1.club LIKE '%$text%' OR
        t1.age LIKE '%$text%'
    )";
    
    $result_manager_info=mysqli_query($conn,$query_manager_info);

    $query_manager_count="SELECT COUNT(*) as counted FROM 
    (
        SELECT person.name,person.mail,person.country,club.name as club,
        TIMESTAMPDIFF
        (
            YEAR,
            (SELECT person.DOB),
            CURDATE()
        ) AS age

        FROM
        person JOIN manager JOIN club 
        ON
        (
            person.id=manager.manager_id AND
            club.club_id=manager.club_id AND
            person.type='Manager' 



        )
    )    
    AS t1
    WHERE
    (
        t1.name LIKE '%$text%' OR
        t1.mail LIKE '%$text%' OR
        t1.country LIKE '%$text%' OR
        t1.club LIKE '%$text%' OR
        t1.age LIKE '%$text%'
    )";

    $result_manager_count=mysqli_query($conn,$query_manager_count);

    while($row = $result_manager_count->fetch_assoc()) 
    {
        $count_manager= $row['counted'];
    }
    //---------------------------------------------------Manager----------------------------------------------------------------------

    



    //---------------------------------------------------player----------------------------------------------------------------------
    $query_player_info="SELECT * FROM 
                        (
                            SELECT person.name,player.position,person.country,club.name as club,
                                                TIMESTAMPDIFF
                                                (
                                                    YEAR,
                                                    (SELECT person.DOB),
                                                    CURDATE()
                                                ) AS age
                                                FROM
                                                person JOIN player JOIN club 
                                                ON
                                                (
                                                    person.id=player.player_id AND
                                                    club.club_id=player.club_id AND
                                                    person.type='Player'
                                                )
                        )    
                        AS t1
                            WHERE
                            (
                                t1.name LIKE '%$text%' OR
                                t1.position LIKE '%$text%' OR
                                t1.country LIKE '%$text%' OR
                                t1.club LIKE '%$text%' OR
                                t1.age LIKE '%$text%'
                            )";
    
    $result_player_info=mysqli_query($conn,$query_player_info);

    $query_player_count="SELECT COUNT(*) as counted FROM 
                        (
                            SELECT person.name,player.position,person.country,club.name as club,
                                                TIMESTAMPDIFF
                                                (
                                                    YEAR,
                                                    (SELECT person.DOB),
                                                    CURDATE()
                                                ) AS age
                                                FROM
                                                person JOIN player JOIN club 
                                                ON
                                                (
                                                    person.id=player.player_id AND
                                                    club.club_id=player.club_id AND
                                                    person.type='Player'
                                                )
                        )    
                        AS t1
                            WHERE
                            (
                                t1.name LIKE '%$text%' OR
                                t1.position LIKE '%$text%' OR
                                t1.country LIKE '%$text%' OR
                                t1.club LIKE '%$text%' OR
                                t1.age LIKE '%$text%'
                            )";

    $result_player_count=mysqli_query($conn,$query_player_count);

    while($row = $result_player_count->fetch_assoc()) 
    {
        $count_player= $row['counted'];
    }
    //---------------------------------------------------player----------------------------------------------------------------------






//---------------------------------------------------club----------------------------------------------------------------------
    $query_club_info="SELECT club.name,club.founded,club.stadium,club.country,club.league
                    FROM club
                    WHERE
                    club.name LIKE '%$text%' OR
                    club.founded LIKE '%$text%' OR
                    club.stadium LIKE '%$text%' OR
                    club.country LIKE '%$text%' OR
                    club.league LIKE '%$text%' 
                    ";
    
    $result_club_info=mysqli_query($conn,$query_club_info);

    $query_club_count="SELECT club.name,club.founded,club.stadium,club.country,club.league,COUNT(*) as counted
                        FROM club
                        WHERE
                        club.name LIKE '%$text%' OR
                        club.founded LIKE '%$text%' OR
                        club.stadium LIKE '%$text%' OR
                        club.country LIKE '%$text%' OR
                        club.league LIKE '%$text%' 
                        ";

    $result_club_count=mysqli_query($conn,$query_club_count);

    while($row = $result_club_count->fetch_assoc()) 
    {
        $count_club= $row['counted'];
    }
//---------------------------------------------------club----------------------------------------------------------------------







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

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/shop-homepage.css" rel="stylesheet">
    
    <style >
        
        body
        {
           background-image: url(background12.jpg );
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
            background: linear-gradient(#1F1C18,#8E0E00);
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

        
        .col-lg-12
        {
            color: white;
            font-size: 18px;
            font-family: Segoe UI Semibold;
        }
        
        
        /*---------------*/
        
            /*----Player Part----*/

            #player_icon {
              width: 30px;
              height: 30px;
              margin-top: 3%;
            }

            #player_icon div {
              width: 100%;
              height: 5px;
              background: white;
              margin: 4px auto;
              transition: all 0.3s;
              backface-visibility: hidden;
            }

            #player_icon.on .one {
              transform: rotate(45deg) translate(5px, 5px);
            }

            #player_icon.on .two {
              opacity: 0;
            }

            #player_icon.on .three {
              transform: rotate(-45deg) translate(7px, -8px);
            }

            #player 
            {
              margin-top: 2%;
              color: black;
              border-radius: 10px;
              padding: 5px;
              text-align: center;
              display: none;
              /*background: linear-gradient(#52c234,#061700);*/
            }
        
            #player_head
            {
                color:  white;
                margin-top: 2.70%;
                margin-left: 2%;
            }
        
            /*Player Table*/
            
            .player_table
            {
                <?php
                    if($count_player==0)
                    {?>
                       display: none;
                <?php
                    }
                    else
                    {?>
                        display: inline-table;
                <?php
                    }
                ?>
                
                border-radius: 10px;
                margin: auto;
                width:100%;
                border-collapse:separate;
                border: solid white 3px;
            }
            .manager_table
            {
                <?php
                    if($count_manager==0)
                    {?>
                       display: none;
                <?php
                    }
                    else
                    {?>
                        display: inline-table;
                <?php
                    }
                ?>
                border-radius: 10px;
                margin: auto;
                width:100%;
                border-collapse:separate;
                border: solid white 3px;
            }
            .club_table
            {
                <?php
                    if($count_club==0)
                    {?>
                       display: none;
                <?php
                    }
                    else
                    {?>
                        display: inline-table;
                <?php
                    }
                ?>
                border-radius: 10px;
                margin: auto;
                width:100%;
                border-collapse:separate;
                border: solid white 3px;
            }

            .table_head
            {
                color: #141414;
                font-size: 25px;
                font-family: arial;
                background-color: white;
                background-color: rgba(255,255,255);
                background-color: rgba(255,255,255,0.3);
            }

            .table_body
            {
                color: #141414; 
                font-size: 21px;
                font-weight: 600;
                font-family: Segoe UI;
                background-color: rgba(255,255,255);
                background-color: rgba(255,255,255,0.3);
            }

            td,th 
            {
                border: 3px #141414;
                text-align: center;
                padding: 8px;
                background-color: rgba(255,255,255);
                background-color: rgba(255,255,255,0.3);
            }
            
            .player_table th:first-child
            {
                border-top-left-radius: 2px;
            }
            .player_table th:last-child
            {
                border-top-right-radius: 2px;
            }
        
            /*----Manager Part----*/
        
            #manager_icon {
              width: 30px;
              height: 30px;
              margin-top: 3%;
            }

            #manager_icon div {
              width: 100%;
              height: 5px;
              background: white;
              margin: 4px auto;
              transition: all 0.3s;
              backface-visibility: hidden;
            }

            #manager_icon.on .one {
              transform: rotate(45deg) translate(5px, 5px);
            }

            #manager_icon.on .two {
              opacity: 0;
            }

            #manager_icon.on .three {
              transform: rotate(-45deg) translate(7px, -8px);
            }

            #manager 
            {
              margin-top: 2%;
              color: black;
              border-radius: 10px;
              padding: 5px;
              text-align: center;
              display: none;
            }
        
            #manager_head
            {
                color:  white;
                margin-top: 2.70%;
                margin-left: 2%;
            }
        
            #club_icon {
              width: 30px;
              height: 30px;
              margin-top: 3%;
            }

            #club_icon div {
              width: 100%;
              height: 5px;
              background: white;
              margin: 4px auto;
              transition: all 0.3s;
              backface-visibility: hidden;
            }

            #club_icon.on .one {
              transform: rotate(45deg) translate(5px, 5px);
            }

            #club_icon.on .two {
              opacity: 0;
            }

            #club_icon.on .three {
              transform: rotate(-45deg) translate(7px, -8px);
            }

            #club 
            {
              margin-top: 2%;
              color: black;
              border-radius: 10px;
              padding: 5px;
              text-align: center;
              display: none;
            }
        
            #club_head
            {
                color:  white;
                margin-top: 2.70%;
                margin-left: 2%;
            }
        
    </style>

</head>

<body>
    
    <!-- Navigation Part -->
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
        
    <!--------------------->

    
     <!-- Player Part -->
        <div class="flex-container" style="display: flex;">
            <div id="player_icon">
                <div class="one"></div>
                <div class="two"></div>
                <div class="three"></div>
            </div>
            <h2 id="player_head"><?php echo $count_player ?> Players Found</h2>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div id="player"> 
                    <div>
                        <table id="table" class="player_table">
                            <thead class="table_head">
                              <tr>
                                <th>Name</th>     
                                <th>Age</th>
                                <th>Position</th>
                                <th>Country</th>
                                <th>Club</th>
                              </tr>
                            </thead>
                            <tbody class="table_body">  
                            <?php while($row = $result_player_info->fetch_assoc()) 
                            {  ?>
                               <tr>
                                  <td><?php echo $row['name'] ?></td>
                                  <td><?php echo $row['age'] ?></td>
                                  <td><?php echo $row['position'] ?></td>
                                  <td><?php echo $row['country'] ?></td>
                                  <td><?php echo $row['club'] ?></td>
                                  
                                </tr>
                            <?php } ?>
                                
                           </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
            
        
        <!-- Manager Part -->
        
        <br>
        <br>
    
        <div class="flex-container" style="display: flex;">
            <div id="manager_icon">
                <div class="one"></div>
                <div class="two"></div>
                <div class="three"></div>
            </div>
            <h2 id="manager_head"><?php echo $count_manager ?> Managers Found</h2>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div id="manager"> 
                    <div>
                        <table id="table" class="manager_table">
                            <thead class="table_head">
                              <tr>
                                <th>Name</th>     
                                <th>Age</th>
                                <th>Mail</th>
                                <th>Country</th>
                                <th>Club</th>
                                
                              </tr>
                            </thead>
                            <tbody class="table_body"> 
                            <?php while($row = $result_manager_info->fetch_assoc()) 
                            {  ?>
                               <tr>
                                  <td><?php echo $row["name"] ?></td>
                                  <td><?php echo $row["age"] ?></td>
                                  <td><?php echo $row["mail"] ?></td>
                                  <td><?php echo $row["country"] ?></td>
                                  <td><?php echo $row["club"] ?></td>
                                </tr>
                        <?php } ?> 
                                
                           </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
                
        <!-- Manager Part -->
    
        <br>
        <br>
    
        <div class="flex-container" style="display: flex;">
            <div id="club_icon">
                <div class="one"></div>
                <div class="two"></div>
                <div class="three"></div>
            </div>
            <h2 id="club_head"><?php echo $count_club ?> Clubs Found</h2>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div id="club"> 
                    <div>
                        <table id="table" class="club_table">
                            <thead class="table_head">
                              <tr>
                                <th>Name</th>     
                                <th>Founded</th>
                                <th>Stadium</th>
                                <th>Country</th>
                                <th>League</th>
                              </tr>
                            </thead>
                            <tbody class="table_body">
                            <?php while($row = $result_club_info->fetch_assoc()) 
                                {  ?>
                               <tr>
                                  <td><?php echo $row["name"] ?></td>
                                  <td><?php echo $row['founded'] ?></td>
                                  <td><?php echo $row['stadium'] ?></td>
                                  <td><?php echo $row['country'] ?></td>
                                  <td><?php echo $row['league'] ?></td>
                            <?php } ?>
                                  
                                </tr>
                           </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    
        <br>
        <br>
        <br>
        <br>
        <br>
    
        <footer>
            <div class="row">
               
                <div class="col-lg-12">
                    <p>Copyright &copy; Fifa World</p>
                </div>
            </div>
        </footer>
                
                
                
        </div>
    

    <!-----/.container----->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script>
        $("#player_icon").click(function() {
            $(this).toggleClass("on");
            $("#player").slideToggle();
        });
        
        $("#manager_icon").click(function() {
            $(this).toggleClass("on");
            $("#manager").slideToggle();
        });
        
        $("#club_icon").click(function() {
            $(this).toggleClass("on");
            $("#club").slideToggle();
        });
    </script>
    
    <!--<script>
        var modal = document.getElementById('details');
        window.onclick = function(event) 
        {
            if (event.target == modal) 
            {
                modal.style.display = "none";
            }
        }
    </script>-->

</body>

</html>
