<?php
//authorization- access control
//checked whether the user is logged in or not
if(!isset($_SESSION['user']))//if the user session is not set
{
//user is not logged in
//redirect to login page with Message
$_SESSION['no-login-message'] = "<div class='error text-center'>please login to acces admin page.</div>";
  //redirect to login page
  header('location:'.SITEURL.'admin/login.php');
}
 ?>
