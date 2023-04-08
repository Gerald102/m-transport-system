<?php
    //include constants file
    include('../config/constants.php');
    //echo"Delete Page";
    //check whether the id and image_name value is set or not
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
      //Get the values and delete
      //echo "Get value and Delete";
      $id = $_GET['id'];
      $image_name = $_GET['image_name'];

      //Remove the physical image file if available
      if($image_name != "")
      {
        //image is available. so remove it
        $path = "../images/vehicle/".$image_name;
        //remove the image
        $remove = unlink($path);

        //if failed to remove the image then add the error message and stop the process
        if($remove==false)
        {
          //set the session message
          $_SESSION['remove']="<div class='error'>Failed to Remove vehicle Image.</div>";
          //redirect to manage vehicle page
          header('location:'.SITEURL.'admin/manage-vehicle.php');
          //stop the proccess
          die();
        }
      }

      //delete data from the database
      //SQL query to delete data from database
      $sql = "DELETE FROM tbl_vehicle WHERE id = $id";

      //execute the Query
      $res = mysqli_query($conn, $sql);

      //check whether the data is deleted from the database or not
      if($res==true)
      {
          //set success message and redirect
          $_SESSION['delete'] = "<div class='success'>vehicle Deleted Successfully.</div>";
          //Redirect to manage vehicle page
          header('location:'.SITEURL.'admin/manage-vehicle.php');
      }
      else
      {
          //set fail message and redirect
          $_SESSION['delete'] = "<div class='error'>Failed to Delete vehicle.</div>";
          //Redirect to manage vehicle page
          header('location:'.SITEURL.'admin/manage-vehicle.php');
      }


    }
    else
    {
      //redirect to manage vehicle page
      header('location:'.SITEURL.'admin/manage-vehicle.php');
    }
 ?>
