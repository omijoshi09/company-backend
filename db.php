<?php
$connection = mysqli_connect('localhost', 'root', '','classicmodels' );
//check connection
if(!$connection){
    die ('Database connection failed');
}