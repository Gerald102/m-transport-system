<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Destination</h1>

        <br><br>

        <?php

        if(isset($_SESSION['upload'])) //Checking whether the session is set or not
        {
            echo $_SESSION['upload']; //Displaying Session message if set
            unset($_SESSION['upload']); //Removing Session message
        }

         ?>

        <form action="" method="POST" enctype="multipart/form-data">

              <table class="tbl-30">

                  <tr>
                      <td>Title: </td>
                      <td>
                          <input type="text" name="title" placeholder="Destination Title">
                      </td>
                  </tr>

                  <tr>
                      <td>Description: </td>
                      <td>
                          <textarea name="description" rows="5" cols="30" placeholder="Description of The Destination."></textarea>
                      </td>
                  </tr>

                  <tr>
                      <td>Price: </td>
                      <td>
                          <input type="number" name="price">
                      </td>
                  </tr>

                  <tr>
                      <td>Select Image: </td>
                      <td>
                          <input type="file" name="image">
                      </td>
                  </tr>

                  <tr>
                      <td>vehicle: </td>
                      <td>
                          <select name="vehicle">

                              <?php
                                  //create PHP code to diplay vehicle from database
                                  //1.create sql to get active vehicle from database
                                  $sql = "SELECT * FROM tbl_vehicle WHERE active='Yes'";

                                  //executing query
                                  $res = mysqli_query($conn, $sql);

                                  //count rows to check whether we have vehicle or not
                                  $count = mysqli_num_rows($res);

                                  //If count is greater than zero,we have vehicle else we do not have categories
                                  if($count>0)
                                  {
                                    //we have vehicle
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        //get the details of vehicle
                                        $id = $row['id'];
                                        $title = $row['title'];

                                        ?>

                                            <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                        <?php
                                    }
                                  }
                                  else
                                  {
                                    //we dont have vehicle
                                    ?>
                                    <option value="0">No vehicle Found</option>
                                    <?php
                                  }


                                  //2.display on dropdown
                               ?>

                          </select>
                      </td>
                  </tr>

                  <tr>
                      <td>Featured: </td>
                      <td>
                          <input type="radio" name="featured" value="Yes"> Yes
                          <input type="radio" name="featured" value="No"> No
                      </td>
                  </tr>

                  <tr>
                      <td>Active: </td>
                      <td>
                          <input type="radio" name="active" value="Yes"> Yes
                          <input type="radio" name="active" value="No"> No
                      </td>
                  </tr>

                  <tr>
                      <td colspan="2">
                        <input type="submit" name="submit" value="Add Destination" class="btn-secondary">
                      </td>
                  </tr>

              </table>

        </form>


        <?php

            //check whether the button is clicked or not
            if(isset($_POST['submit']))
            {
              //Add the Destination in the Database
              //echo "Clicked";

              //1.Get the data from form
              $title = $_POST['title'];
              $description = $_POST['description'];
              $price = $_POST['price'];
              $vehicle = $_POST['vehicle'];

              //check whether radio button for featured and active are checked or not
              if(isset($_POST['featured']))
              {
                  $featured = $_POST['featured'];
              }
              else
              {
                  $featured = "No"; //setting default value
              }

              if(isset($_POST['active']))
              {
                  $active = $_POST['active'];
              }
              else
              {
                  $active = "No"; //setting default value
              }

              //2.Upload the image if selected
              //check whether the select image is clicked or not and upload the image if the image is selected
              if(isset($_FILES['image']['name']))
              {
                  //get the details of the selected image
                  $image_name = $_FILES['image']['name'];

                  //check whether the image is selected or not and uupload the image only if selected
                  if($image_name!="")
                  {
                      //image selected
                      //A.rename the image
                      //get the extension of the selected image (jpg,png)
                      $ext = end(explode('.', $image_name));

                      //create new name for image
                      $image_name = "Destination-Name-".rand(0000,9999).".".$ext; //new image name will be like (Destination-Name-345.jpg)

                      //B.Upload the image
                      //get the source path and destination path

                      //source path is the current location of the  image
                      $src= $_FILES['image']['tmp_name'];
                      //Destination path for the image to be uploaded
                      $dst = "../images/destination/".$image_name;

                      //finally upload the destination image
                      $upload = move_uploaded_file($src, $dst);

                      //check whether image uploaded or not
                      if($upload==false)
                      {
                        //Failed to upload the image
                        //Redirect to Add Destination page with error message
                        $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                        header('location:'.SITEURL.'admin/add-destination.php');
                        //stop the process
                        die();
                      }

                  }
              }
              else
              {
                  $image_name = ""; //setting default value as blank
              }

              //3.Insert into database

              //create sql query to save or add destination
              $sql2 = "INSERT INTO tbl_destination SET
              title = '$title',
              description = '$description',
              price = $price,
              image_name = '$image_name',
              vehicle_id = $vehicle,
              featured = '$featured',
              active = '$active'
              ";

              //execute the Query
              $res2 = mysqli_query($conn, $sql2);
              //check data inserted or not

              //4.redirect with message to manage destination page
              if($res==true)
              {
                 //Data inserted Successfully
                 $_SESSION['add'] = "<div class='success'>Destination Added Successfully.</div>";
                 header('location:'.SITEURL.'admin/manage-destination.php');
              }
              else
              {
                //Failed to insert data
                $_SESSION['add'] = "<div class='error'>Destination Added Successfully.</div>";
                header('location:'.SITEURL.'admin/manage-destination.php');
              }


            }

         ?>


    </div>
</div>

<?php include('partials/footer.php'); ?>
