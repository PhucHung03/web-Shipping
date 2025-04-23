<?php

   $host = 'localhost';
   $db_name = 'webshipping';
   $username = 'root';
   $password = '';

   $conn = new mysqli($host, $username, $password, $db_name);
   if(!$conn){
         echo 'Kết nối thất bại: ';
   }

   return $conn;
?> 