<?php 
    define('DB_HOST','localhost');
    define('DB_USER','Molise');
    define('DB_PASSWORD','');
    define('DB_NAME','MintRepairs');

    //create a connection
    $conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    
    //check for connection
    if($conn->connect_error){
        die('connect failed' .$conn->connect_error);
    }else{
        echo"what";
    }
    
?>
