<?php include('../config/constants.php'); ?>
<html >
  <head>
    <title> login</title>
    <link rel="stylesheet" href="../css/admin.css">
  </head>
  <body>
    <div class="login" >
      <h1 class="text-center">Login</h1>
      <br><br>
      <?php
        if(isset($_SESSION['login']))
        {
          echo $_SESSION['login'];
          unset ($_SESSION['login']);
        }
        if(isset($_SESSION['no-login-message']))
        {

            echo $_SESSION['no-login-message'];
            unset ($_SESSION['no-login-message']);
        }
       ?>
       <br>
      <!--login form starts here -->
      <form action="" method="POST" class="text-center">
        Username:<br>
        <input type="text" name="username" placeholder="Enter Username">
        <br><br>
        Password:<br>
        <input type="password" name="password" placeholder="Enter Password"><br><br>
        <input type="submit" name="submit" value="login" class="btn-primary">
        <br><br>
      </form>

        </div>

  </body>
</html>
<?php
  //check if the button submit is clicked
  if(isset($_POST['submit']))
  {
    //process for Login
    //1. Get the data from the login page
    $username = $_POST['username'];
    $password =md5 ( $_POST['password']);

    // 2. Sql to check whether the username and password exist or not
    $sql = "SELECT * FROM tbl_admin WHERE username ='$username' AND password = '$password'";
    // 3. Execute the query
    $res = mysqli_query($conn, $sql);
    // 4. count the rows to check whether the user exist or not
    $count = mysqli_num_rows($res);

    if ($count == 1)
     {
      // User is available and login successful
      $_SESSION['login'] = "<div class ='success'> Login successfully.</div>";
      $_SESSION['user'] = $username; //check hether the user is loged in or not and logout will unset interface




       //redirecting to home page
      header('location:'.SITEURL.'admin/');

     }
     else
      {
       //User is not  available and login fail
       $_SESSION['login'] = "<div class = 'error text-center'> Login failed! Username and Password did not match </div>";
       //redirecting to login page
       header('location:'.SITEURL.'admin/login.php');
       }





  }


?>
