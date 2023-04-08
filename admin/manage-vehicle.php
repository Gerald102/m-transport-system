<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
         <h1>Manage vehicle</h1>

         <br />  <br />
         <?php
             if(isset($_SESSION['add'])) //Checking whether the session is set or not
             {
                 echo $_SESSION['add']; //Displaying Session message if set
                 unset($_SESSION['add']); //Removing Session message
             }

             if(isset($_SESSION['remove']))
             {
                 echo $_SESSION['remove'];
                 unset($_SESSION['remove']);
             }

             if(isset($_SESSION['delete']))
             {
                 echo $_SESSION['delete'];
                 unset($_SESSION['delete']);
             }

             if(isset($_SESSION['no-vehicle-found']))
             {
                 echo $_SESSION['no-vehicle-found'];
                 unset($_SESSION['no-vehicle-found']);
             }

             if(isset($_SESSION['update']))
             {
                 echo $_SESSION['update'];
                 unset($_SESSION['update']);
             }

             if(isset($_SESSION['upload']))
             {
                 echo $_SESSION['upload'];
                 unset($_SESSION['upload']);
             }

             if(isset($_SESSION['failed-remove']))
             {
                 echo $_SESSION['failed-remove'];
                 unset($_SESSION['failed-remove']);
             }


          ?>
          <br><br>

         <!-- Button to Add Admin -->
         <a href="<?php  echo SITEURL; ?>admin/add-vehicle.php" class="btn-primary">Add vehicle</a>

         <br />    <br />


         <table class="tbl-full">
           <tr>
             <th>S.N</th>
             <th>Title</th>
             <th>Image</th>
             <th>Featured</th>
             <th>Active</th>
             <th>Actions</th>
           </tr>

           <?php

              //Query to get all vehicle from database
              $sql = "SELECT * FROM tbl_vehicle";

              //execute the query
              $res = mysqli_query($conn, $sql);

              //count rows
              $count = mysqli_num_rows($res);

              //Create serial number variable and assign value as 1
              $sn=1;

              //check whether we have data in the database or not
              if($count>0)
              {
                //we have data in the database
                //get the data and display
                while($row=mysqli_fetch_assoc($res))
                {
                  $id = $row['id'];
                  $title =$row['title'];
                  $image_name = $row['image_name'];
                  $featured = $row['featured'];
                  $active = $row['active'];

                  ?>

                      <tr>
                        <td><?php echo $sn++; ?>. </td>
                        <td><?php echo $title; ?></td>

                        <td>

                        <?php
                                //check whether image name is available or not
                                if($image_name!="")
                                {
                                  //Display the image
                                  ?>
                                  <img src="<?php echo SITEURL; ?>images/vehicle/<?php echo $image_name; ?>" width="100px" >
                                  <?php
                                }
                                else
                                {
                                  // display the message
                                  echo "<div class='error'>Image Not Added.</div>";
                                }
                           ?>
                           

                        </td>

                        <td><?php echo $featured; ?></td>
                        <td><?php echo $active; ?></td>
                        <td>
                          <a href="<?php echo SITEURL; ?>admin/update-vehicle.php?id=<?php echo $id; ?>"class="btn-secondary">Update vehicle</a>
                          <a href="<?php echo SITEURL; ?>admin/delete-vehicle.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete vehicle</a>
                        </td>
                      </tr>

                  <?php

                }
              }
              else
              {
                  //we do not have data
                  //we will diplay the messsage inside the table
                  ?>

                  <tr>
                    <td colspan="6"><div class="error">No vehicle Added.</div></td>
                  </tr>

                  <?php
              }

            ?>

         </table>
    </div>

</div>

<?php include('partials/footer.php'); ?>
