<?php include('partials/menu.php');?>
<?php
ob_start();
        //check whether the id is set or not
        if(isset($_GET['id']))
        {
          //Get the ID and all other details
        $id = $_GET['id'];

        //Create sql query to get all other details
        $sql2 = "SELECT * FROM tbl_destination WHERE id=$id";
        //Execute the query
        $res2 = mysqli_query($conn, $sql2);

        //get the value based on query executed
        $row2 = mysqli_fetch_assoc($res2);

        //get the values of selected destination
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $vehicle = $row2['vehicle_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];

        }
        else
        {
          //redirect
          header('location:'.SITEURL.'admin/manage-destination.php');
        }
?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update destination</h1>

        <br><br>


        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">

                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Destination Title goes in Here." value="<?php echo $title;?>">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="20" rows="5"><?php echo $description;?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price;?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                     <?php
                          if($current_image == "")
                          {
                            //image not available
                            echo "<div class='error'> Image not available.</div>";

                          }
                          else
                          {
                            //image available
                             ?>
                            <img src="<?php echo SITEURL;?>photos/destination/<?php echo $current_image;?>" width="150px">
                            <?php
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
                        <td>vehicle: </td>
                        <td>
                          <select name="vehicle">
                             <?php
                                  //query to get active type
                                    $sql = "SELECT * FROM tbl_vehicle WHERE active='Yes'";
                                    //execute te Query
                                    $res = mysqli_query($conn, $sql);
                                    //count rows
                                    $count = mysqli_num_rows($res);
                                    //check whether the destination is available or not
                                    if($count>0)
                                    {
                                      //vehicle available
                                        while($row=mysqli_fetch_assoc($res))
                                        {
                                          $vehicle_title = $row['title'];
                                          $vehicle_id = $row['id'];

                                          ?>

                                          <option <?php if($current_vehicle==$vehicle_id){echo "selected";}?> value="<?php echo $vehicle_id;?>"><?php echo $vehicle_title;?></option>
                                          <?php
                                        }
                                    }
                                    else
                                    {
                                      //destination not available
                                      echo "<option value = '0'>Destination not available.</option>";
                                    }
                             ?>
                          </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Featured: </td>
                        <td>
                            <input <?php if($featured=="Yes") { echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes
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
                          <input type="hidden" name="id" value="<?php echo $id;?>">
                          <input type="hidden" name="current_image" value="<?php echo $current_image;?>">
                          <input type="submit" name="submit" value="Update destination" class="btn-secondary">
                        </td>
                    </tr>
            </table>

        </form>
        <?php
            if(isset($_POST['submit']))
            {
                  //echo "Clicked";
                  //1.Get all the values from our form
                  $id=$_POST['id'];
                  $title = $_POST['title'];
                  $description = $_POST['description'];
                  $price = $_POST['price'];
                  $current_image = $_POST['current_image'];
                  $vehicle = $_POST['vehicle'];
                  $featured = $_POST['featured'];
                  $active = $_POST['active'];

                  //2.updating new image if selected
                  //check whether the image is selected or not
                  if(isset($_FILES['image']['name']))
                  {
                        //get the image details
                        $image_name = $_FILES['image']['name'];

                        //Check whether the image is available or not
                        if($image_name!="")
                        {
                          //image available

                          //A.upload the new image

                          //Auto rename our image
                          //Get the image extension

                          $ext = end(explode('.',$image_name));

                          //Rename the image
                          $image_name = "Destination_vehicle_".rand(0000, 9999).'.'.$ext; //e.g Destination_vehicle_765.jpg

                          $src_path = $_FILES['image']['tmp_name'];

                          $dest_path = "../images/destination/".$image_name;

                          // finally upload the image
                          $upload = move_uploaded_file($src_path, $dest_path);

                          // check whether the image is uploaded or not
                          // and if it is not uploaded, the process should stop n redirected with n error Message
                          if($upload==false)
                          {
                                  // Set Message
                                  $_SESSION['upload'] = "<div class= 'error'>Failed to  upload. </div>";
                                  // redirect to add-destination
                                  header('location:'.SITEURL.'admin/manage-destination.php');
                                  // stop the process
                                  die();
                          }
                              //B.remove the current image if available
                              if($current_image!="")
                              {
                                  $remove_path = "../images/destination/".$current_image;

                                  $remove = unlink($remove_path);
                                  //check whether the image is removed or not
                                  //if failed to remove then display the message and stop the process
                                  if($remove==false)
                                  {
                                        //failed to remove the image
                                        $_SESSION['failed-remove'] = "<div class='error'>Failed to Remove Current Image.</div>";
                                        header('location:'.SITEURL.'admin/manage-destination.php');
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
                  $sql3 = "UPDATE tbl_destination SET
                    	title = '$title',
                    	description = '$description',
                    	price = '$price',
                    	image_name = '$image_name',
                    	vehicle_id= '$vehicle',
                    	featured = '$featured',
                    	active = '$active'
                    	 WHERE id=$id
                  ";
                  //execute the Query
                  $res3 = mysqli_query($conn, $sql3);

                  //4.Redirect to manage vehicle with Message
                  //check whether query executed or not
                  if($res3==true)
                  {
                    //category updated
                    $_SESSION['update'] = "<div class='success'>destination Updated Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-destination.php');
                    ob_end_flush();
                  }
                  else
                  {
                    //failed to update vehicle
                    $_SESSION['remove-failed'] = "<div class='error'>Failed to update destination.</div>";
                    header('location:'.SITEURL.'admin/manage-destination.php');
                  }
            }
         ?>
    </div>
</div>
<?php include('partials/footer.php'); ?>
