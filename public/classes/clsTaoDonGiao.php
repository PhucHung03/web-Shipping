<?php 
    class ClsTaoDonGiao {
        public function taoDonGiao($sql){
            require_once 'config/conn.php';

            if(isset($conn) && mysqli_query($conn,$sql)){
                return 1;
            }else{
                return 0;
            }
        }   
    }


?>