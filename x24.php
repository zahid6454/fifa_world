
<?php
    
    include("connect.php");
    
    $manager_username=$_GET['username']; 
    $loggedUsername=$manager_username;
    $loginpass=$_GET['loginpass'];
    

    $sql= "SELECT manager.club_status 
           FROM manager NATURAL JOIN person 
           WHERE manager.manager_id=person.id AND person.username='$manager_username'";
    
    $result=mysqli_query($conn,$sql);

    while($row = $result->fetch_assoc()) 
    {
        $club_status= $row['club_status'];    
    }
    
    if($club_status=='unavailable')
    {
        if($loginpass==1)
        {
            $sql="SELECT id
                  FROM person
                  WHERE username='$manager_username'";

            $result=mysqli_query($conn,$sql);

            while($row = $result->fetch_assoc()) 
            {
                $manager_id= $row["id"];    
            }
        }
        else    
        {
            $manager_id = $_GET['manager_id'];
        }

        $sql = "SELECT club_logo,name,club_id
                FROM club
                WHERE club.manager_status='unavailable' AND   
                club_id IN
                (
                   SELECT club_id
                   FROM club
                   WHERE club_id NOT IN 
                   (
                      SELECT club_id
                      FROM club_request
                      WHERE
                      id='$manager_id'
                   )    
                )";

        $sql2 = "SELECT club_logo,name,club_id
                FROM club
                WHERE club_id IN
                (
                   SELECT club_id
                   FROM club_request
                   WHERE
                   id='$manager_id'    
                )";


        $result=mysqli_query($conn,$sql);
        $result2=mysqli_query($conn,$sql2);
    }
    else if($club_status=='available')
    {
        header ("Location: profile.php?username=$manager_username &loginpass=1");
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

    <title>Profile: Choose Club</title>

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


        /* Table Part */
        
        .request_available_header
        {
            text-align: center;
            padding-top: 20px;
            color: #141414;
            font-family: arial; 
        }
        
        .request_available_table
        {
            margin: auto;
            margin-top: 35px;
            width:90%;
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

        .request_sent_header
        {
            margin-top: 50px;
            text-align: center;
            padding-top: 20px;
            color: #141414;
            font-family: arial; 
        }
        
        .request_sent_table
        {
            margin: auto;
            margin-top: 35px;
            width:90%;
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
        
        #apply_button
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
        }
        #apply_button:after
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
        #apply_button:hover 
        {
            color: white;
            opacity: 0.8;
        }
        
        #cancel_button
        {
            position: relative;
            display: inline-block;
            padding: 6px 12px;
            background-color: green;
            background: linear-gradient(#e52d27,#b31217);
            
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
                          <a class="navbar-brand" href="main.php? username=<?php echo $manager_username ?>" style="color:white">FIFA WORLD</a>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="navbar-collapse-3">
                          <ul id="search_panel" class="nav navbar-nav navbar-right">
                            <li><a href="squad.php? username=<?php echo $loggedUsername?>" style="color:white">Squad</a></li>
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
        <h1 class="request_available_header">Request Available Table</h1>
    
        <table class="request_available_table">
            <thead class="table_head">
              <tr>
                <th>CLub Logo</th>
                <th>Club name</th>
                <th style="display: none;">Club ID</th>      
                <th>Request</th>      
              </tr>
            </thead>
            <tbody class="table_body">   
                <?php
                while($row = $result->fetch_assoc())
                {
                ?>
                <tr>
                  <td><img src="<?php echo $row['club_logo']; ?> "></td>    
                  <td><?php echo $row['name']; ?></td>
                  <td style="display: none;"><?php echo $row['club_id']; ?></td>
                    
                    
                    
                    <td><button id="apply_button" class="glass" type="button" onClick="addme('<?php echo $row['club_id'];?>')" name="add" value="Apply">Apply</button>
                </td>
                </tr>
                
                
                 <script language="javascript">

                    function addme(clubid)
                    {
                          var manager = "<?php echo $manager_id ?>";   
                            var managerUsername = "<?php echo $manager_username ?>";   
                            window.location.href='manager_add.php?club_id='+clubid+'& managerid='+manager+'& manager_username='+managerUsername+'& command='+1+'';
                    }
                </script>
                
                <?php
                }
                ?>
           </tbody>
               
        </table>
        </div>
        
        
        
         <div>
        <h1 class="request_sent_header">Request Sent Table</h1>
    
        <table class="request_sent_table">
            <thead class="table_head">
              <tr>
                <th>CLub Logo</th>
                <th>Club name</th>
                <th style="display: none;">Club ID</th>
                <th>Request</th>
              </tr>
            </thead>
            <tbody class="table_body">   
                <?php

                while($row = $result2->fetch_assoc())
                {
                ?>
                <tr>
                  <td><img src="<?php echo $row['club_logo']; ?>" ></td>     
                  <td><?php echo $row['name']; ?></td>
                  <td style="display: none;"><?php echo $row['club_id']; ?></td>
                    
                    
                    
                  <td><button id="cancel_button" class="glass" type="button" onClick="cancelme('<?php echo $row['club_id'];?>')" name="delete" value="Cancel">Cancel</button>
                </td>
                </tr>
                
                
                 <script language="javascript">

                    function cancelme(clubid)
                    {
                        if(confirm("Do you want to request!"))
                        {
                            var manager = "<?php echo $manager_id ?>";   
                            var managerUsername = "<?php echo $manager_username ?>";   
                            window.location.href='manager_add.php?club_id='+clubid+'& managerid='+manager+'& manager_username='+managerUsername+'& manager_username='+managerUsername+'& command='+0+'';
                            return true;
                        }
                    } 
                </script>
                
                <?php
                }
                ?>
           </tbody>
            
           <?php $conn->close(); ?>
                
        </table>
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

</body>

</html>