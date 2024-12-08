<?php
session_start();

if(isset($_SESSION['username'])){
header(header:"location: login.php");
exit();
}