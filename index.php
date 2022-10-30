<?php

include("connect.php");

global $loginstatus;


if(isset($_POST['Submit']))
{    
   
    if(isset($_POST["Username"]) && isset($_POST["Password"]))
    {
        
        
        $username=trim($_POST["Username"]);
        $password=$_POST["Password"];



        $x=0;
        $loginstatus=0;

        $sql = "SELECT username,password,type FROM person where username='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) 
        {
            while($row = $result->fetch_assoc()) 
            { 
                if($row["username"]==$username)
                {
                    if($row["password"]==$password)
                    {
                        $type=$row["type"];
                        $loginstatus=0;
                        
                        if($type=='Manager')
                        {
                            header ("Location: main.php?username=$username&loginpass=1");
                        }
                        else if($type=='Scout')
                        {
                            header ("Location: main.php?username=$username&loginpass=1");
                        }
                        else if($type=='Owner')
                        {
                            header ("Location: owner.php?username=$username");
                        }
                        
                        
                        break;
                    }
                    else
                    {
                        $loginstatus=1;
                        break;
                    }
                   
                }
                else
                {
                    $loginstatus=1;
                    break;
                }
              
            }
        } 
        else 
        {
            $loginstatus=1;
                
        }


        $conn->close();
    }

}
    
?> 



<!DOCTYPE html>
<html lang="en">
  
    <head>
        
        <title>Log-In Form</title>
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="stylesheet" type="text/css" href="css/style.css"></link>
    
        <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
        <style>
            
            body
            {
                background-image: url(background4.jpg);
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
                background-attachment: fixed;
                background-repeat: no-repeat;
                background-position: center center;
                
            }
            
            .container
            {
                width: 450px;
                height: 350px;
                text-align: center;
                background-color: rgba(255,255,255,0.20);
                border-radius: 10px;
                margin: 0 auto;
                margin-top: 200px;
                box-shadow: inset -5px -5px rgba(0,0,0,0.4);
            }
            
            .very_container
            {
/*
                width: 450px;
                height: 350px;
*/
                text-align: center;
                background-color: rgba(255,255,255,0.20);
                border-radius: 10px;
                margin: 0 auto;
/*                margin-top: 200px;*/
                box-shadow: inset -5px -5px rgba(0,0,0,0.4);
            }
            
            .login_header
            {
                font-family: Segoe UI Light;
                font-size: 2.2em;
                padding: 15px;
                text-align: center;
                text-transform:uppercase;
                color: #fff;
            }
            
            .forgot_password
            {
                font-family: Segoe UI Semibold;
                text-transform:uppercase;
                
                font-size: 12px;
                color: white;
            }
            
            .create_account
            {
                margin: 0 auto;
                font-family: Segoe UI Semibold;
                text-transform:uppercase;
                
                font-size: 12px;
                color: white;
            }
            
            input[type="username"]
            {
                height: 45px;
                width: 300px;
                font-size: 20px;
                margin-bottom: 10px;
                background-color: #fff;
                padding-left: 30px;
            }
            
            input[type="password"]
            {
                height: 45px;
                width: 300px;
                font-size: 20px;
                margin-top: 10px;
                margin-bottom: 10px;
                background-color: #fff;
                padding-left: 30px;
            }
            
            .button-submit
            {
                text-transform:uppercase;
                font-size: 15px;
                text-align: center;
                padding: 15px 55px;
                color: #fff;
                background-color: #2ECC71;
                border-radius: 4px;
                border: none;
                border-bottom: 4px solid #22A358;
                margin-top: 10px;
                margin-bottom: 10px;
            }
            
            .download
            {
                margin: 0 auto;
                font-family: Segoe UI Semibold;
                text-transform:uppercase; 
                font-size: 12px;
                color: white;
            }
            
           .error
            {
                font-size: 20px;
                color: #ffff00;
                text-transform:uppercase;
                display: none;
                
                
                    <?php
                    
                    if($loginstatus==0)
                    {
                        ?>
                        display: none;
                        <?php
                    }
                    
                    if ($loginstatus==1) 
                    {
                        ?>
                        display:block;
                        <?php
                    } 
                   
                    ?>
             
            }
            
        </style>
    
    
        
    </head>
 
    
    <body>
        
        
        <div class="container">
            
            <form action="index.php" method="post">
                
                <h1 class="login_header">Log-In</h1>
                
                <div class="form-input">
                    <input type="username" name="Username" placeholder="Username" required>
                </div>
                        
                <div class="form-input">
                    <input type="password" name="Password" placeholder="Password" required>
                </div>
                
                <button href="main.php" class="button-submit" type="submit" name="Submit" >Submit</button>
                
                
                
                <div>
                    <a class="create_account" href="create_account.php">Create An Account</a>
                </div>
                
                <div>
                    <a class="download" href="Download.pdf" download>Download Username & Password</a>
                </div>
                
                 <div>
                    <p class="error">Wrong User Name Or Password !!</p>
                </div>
                      
            </form>
            
        </div>
        
        <!--Mash-->
        
        
        
        <!--Mash-->
        
        
    </body>
    
</html>