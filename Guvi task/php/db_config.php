<?php
    $servername='localhost';
    $username='root';
    $password='';
    $dbname = "register";
    $connection=mysqli_connect($servername,$username,$password,"$dbname");
      if(!$connection){
          die('Could not Connect MySql Server:' .mysql_error());
          
        }
        return $connection;