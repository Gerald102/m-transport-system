<?php
    // Include constants.php file here
    include('../config/constants.php');

    // 1.Get the ID of the Admin to be deleted
    $id = $_GET['id'];

    // 2.Create SQl Query to Delete Admin
    $sql = "DELETE FROM tbl_admin WHERE id=$id";
    //Execute the Query
    $res = mysqli_query($conn, $sql);
    //Check whether the Query is executed or not
    if($res==true)
    {
      //Query executed Successfully and Admin Deleted
      //echo"Admin Deleted";
      //Create SESSION varriable to diplay the message
      $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully.</div>";
      //Redirect to Manage Admin page
      header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else
     {
      // Failed to Delete Admin
      //echo"Failed to Delete Admin";
      $_SESSION['delete'] = "<div class='error'>Failed to Delete Admin. Try Again Later.</div>";
      //Redirect to Manage Admin page
      header('location:'.SITEURL.'admin/manage-admin.php');
    }

    // 3. Redirect to Manage Admin Page with message (sucesss/error)

 ?>
