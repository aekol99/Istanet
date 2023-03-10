<?php

try{
    $con = new PDO("mysql:host=localhost;dbname=istanet","root","");  
} catch(PDOExecption $e){
    echo "Error " . $e->getMessage();
}

try{
    $istabookCon = new PDO("mysql:host=localhost;dbname=istabook","root","");  
} catch(PDOExecption $e){
    echo "Error " . $e->getMessage();
}