<?php
 //include constants.php
 include('../config/constants.php');
//destroy the Session
session_destroy();//unsets $_SESSION['user']

//redirect to login page
header('location:'.SITEURL.'admin/login.php');


  ?>
