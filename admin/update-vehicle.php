<?php include('partials/menu.php'); ?>

<div class="main-vehicle">
    <div class="wrapper">
        <h1>Update vehicle</h1>

        <br><br>


        <?php

            //check whether the id is set or not
            if(isset($_GET['id']))
            {
               //Get the ID and all other details
               //echo "Getting the Data";
               $id = $_GET['id'];
               //Create sql query to get all other details
               $sql = "SELECT * FROM tbl_vehicle WHERE id=$id";

               //Execute the query
               $res = mysqli_query($conn, $sql);

               //count the rows to check whether the id is valid or not
               $count = mysqli_num_rows($res);

               if($count==1)
               {
                 //get all the data
                 $row = mysqli_fetch_assoc($res);
                 $title = $row['title'];
                 $current_image = $row['image_name'];
                 $featured = $row['featured'];
                 $active = $row['active'];
               }
               else
               {
                 //redirect to manage vehicle with session message
                 $_SESSION['no-vehicle-found'] = "<div class='error'>vehicle Not Found.</div>";
                 header('location:'.SITEURL.'admin/manage-vehicle.php');
               }
            }
            else
            {
              //redirect to manage vehicle
              header('location:'.SITEURL.'admin/manage-vehicle.php');
            }

         ?>

        <form class="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                         <?php
                            if($current_image !="")
                            {
                              //display the image
                              ?>
                                <img src="<?php echo SITEURL; ?>images/vehicle/<?php echo $current_image; ?>" width="150px">
                              <?php
                            }
                            else
                            {
                              //display image
                              echo "<div class='error'>Image Not Added.</div>";
                            }
                         ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image: </td>
                    <td>
                        <input type="file" name="image" >
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes"){ echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes

                        <input <?php if($featured=="No") { echo "checked";} ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active=="Yes"){ echo "checked";} ?> type="radio" name="active" value="Yes"> Yes

                        <input <?php if($active=="No"){ echo "checked";} ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update vehicle" class="btn-secondary">
                    </td>

                </tr>

            </table>

        </form>

        <?php

            if(isset($_POST['submit']))
            {
                //echo "Clicked";
                //1.Get all the values from our form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //2.updating new image if selected
                //check whether the image is selected or not
                if(isset($_FILES['image']['name']))
                {
                  //get the image details
                  $image_name = $_FILES['image']['name'];

                  //Check whether the image is available or not
                  if($image_name != "")
                  {
                    //image available

                    //A.upload the new image

                    //Auto rename our image
                    //Get the image extension
                    $ext = end(explode('.', $image_name));

                    //Rename the image
                    $image_name = "Destination_vehicle_".rand(000, 999).'.'.$ext; //e.g Destination_vehicle_765.jpg

                    $source_path = $_FILES['image']['tmp_name'];

                    $destination_path = "../image/vehicle/".$image_name;

                    // finally upload the image
                    $upload = move_uploaded_file($source_path, $destination_path);
                    // check whether the image is uploaded or not
                    // and if it is not uploaded, the process should stop n redirected with n error Message
                    if($upload==false)
                    {
                        // Set Message
                        $_SESSION['upload'] = "<div class = 'error'>Failed to  upload. </div>";
                        // redirect to add-types
                        header('location:'.SITEURL.'admin/manage-vehicle.php');
                        // stop the process
                        die();
                    }
                    //B.remove the current image if available
                    if($current_image!="")
                    {
                        $remove_path = "../images/vehicle/".$current_image;

                        $remove = unlink($remove_path);
                        //check whether the image is removed or not
                        //if failed to remove then display the message and stop the process
                        if($remove==false)
                        {
                          //failed to remove the image
                          $_SESSION['failed-remove'] = "<div class='error'>Failed to Remove Current Image.</div>";
                          header('location:'.SITEURL.'admin/manage-vehicle.php');
                          die(); //stop the process
                        }
                    }
                    
                  }
                  else
                  {
                    $image_name = $current_image;
                  }
                }
                else
                {
                  $image_name = $current_image;
                }

                //3.update the Database
                $sql2 = "UPDATE tbl_vehicle SET
                    title = '$title',
                    image_name ='$image_name',
                    featured = '$featured',
                    active = '$active'
                    WHERE id=$id
                ";

                //execute the Query
                $res2 = mysqli_query($conn, $sql2);

                //4.Redirect to manage vehicle with Message
                //check whether query executed or not
                if($res2==true)
                {
                  //vehicle updated
                  $_SESSION['update'] = "<div class='success'>vehicle Updated Successfully.</div>";
                  header('location:'.SITEURL.'admin/manage-vehicle.php');
                }
                else
                {
                  //failed to update vehicle
                  $_SESSION['update'] = "<div class='error'>Failed to update vehicle.</div>";
                  header('location:'.SITEURL.'admin/manage-vehicle.php');
                }

            }

         ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>
