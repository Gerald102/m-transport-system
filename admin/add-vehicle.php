<?php include('partials/menu.php'); ?>

<div class="main-content">
  <div class="wrapper">
    <h1>Add Vehicle</h1>

    <br><br>

    <?php
        if(isset($_SESSION['add'])) //Checking whether the session is set or not
        {
            echo $_SESSION['add']; //Displaying Session message if set
            unset($_SESSION['add']); //Removing Session message
        }

        if(isset($_SESSION['upload'])) //Checking whether the session is set or not
        {
            echo $_SESSION['upload']; //Displaying Session message if set
            unset($_SESSION['upload']); //Removing Session message
        }



     ?>

     <br><br>


    <form action="" method="POST" enctype="multipart/form-data">


      <table class="tbl-30">
        <tr>
          <td>Title: </td>
          <td>
            <input type="text" name="title" placeholder="Vehicle title">
          </td>
        </tr>


        <tr>
          <td>Select image:</td>
          <td>
            <input type="file" name="image">
          </td>
        </tr>

        <tr>
          <td>featured: </td>
          <td>
            <input type="radio" name="featured" value="Yes">Yes
            <input type="radio" name="featured" value="No">No
          </td>
        </tr>

        <tr>
          <td>Active:</td>
          <td>
            <input type="radio" name="active" value="Yes">Yes
            <input type="radio" name="active" value="No">No
          </td>
        </tr>

        <tr>
          <td colspan="2">
            <input type="submit" name="submit" value="Add Vehicle" class="btn-secondary">
          </td>
        </tr>

      </table>

    </form>
      <!--Add types ends here -->

      <?php

      //check if the button submit is clicked
      if(isset($_POST['submit']))
      {
          //echo "Clicked";

        //1. Get the value from types form
        $title = $_POST['title'];

        // For radio button we need to check whether it is seleted or not
        if(isset($_POST['featured']))
        {
          //Get the value from form
          $featured = $_POST['featured'];
        }
        else
        {
          // Set the default valule.
          $featured = "No";
        }
        if(isset($_POST['active']))
        {
          // Get the value from form
          $active = $_POST['active'];
        }
        else
        {
          // Set the default valule.
          $active = "No";
        }

        // check whether the image is selected or not and set the value for image name accordingly
        //print_r($_FILES['image']);

        //die(); //Break the codes here
        if(isset($_FILES['image']['name']))
        {
            // upload image
            // to upload image you need image name, source path n destination path
            $image_name = $_FILES['image']['name'];

            //upload the image only when the image is selected
            if($image_name != "")
            {
              
                  //Auto rename our image
                  //Get the image extension
                  $ext = end(explode('.', $image_name));

                  //Rename the image
                  $image_name = "Destination_Vehicle_".rand(000, 999).'.'.$ext; //e.g Destination_Vehicle_765.jpg

                  $source_path = $_FILES['image']['tmp_name'];

                  $destination_path = "../images/vehicle".$image_name;

                  // finally upload the image
                  $upload = move_uploaded_file($source_path, $destination_path);
                  // check whether the image is uploaded or not
                  // and if it is not uploaded, the process should stop n redirected with n error Message
                  if($upload==false)
                  {
                      // Set Message
                      $_SESSION['upload'] = "<div class = 'error'>Failed to  upload. </div>";
                      // redirect to add-types
                      header('location:'.SITEURL.'admin/add-vehicle.php');
                      // stop the process
                      die();
                  }
            }
        }
        else
        {
            // don't upload image and set image_name to blank
            $image_name="";
        }

        // 2. Create sql to insert Vehicle into database
        $sql = "INSERT INTO tbl_vehicle SET
            title='$title',
            image_name='$image_name',
            featured='$featured',
            active='$active'
        ";

        //3. Execute the query and save in the database
        $res = mysqli_query($conn, $sql);

        //4. check whether the query is executed or not and data added or not
        if($res==true)
        {
            //Query executed and Vehicle added
            $_SESSION['add'] = "<div class='success'>Vehicle Add Successfully</div>";
            //Redirect Page Manage Vehicle
            header('location:'.SITEURL.'admin/manage-Vehicle.php');
        }
        else
        {
            //Failed to Add Vehicle
            $_SESSION['add'] = "<div class='error'>Failed To Add Vehicle</div>";
            //Redirect Page Manage Vehicle
            header('location:'.SITEURL.'admin/add-Vehicle.php');
        }

      }


       ?>



  </div>

</div>
<?php include('partials/footer.php'); ?>
