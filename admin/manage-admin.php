<?php include('partials/menu.php'); ?>


      <!-- main content section starts -->
      <div class="main-content">
        <div class="wrapper">
          <h1>Manage Admin</h1>

          <br />

          <?php
              if(isset($_SESSION['add']))  //Checking whether the session is set or not
              {
                  echo $_SESSION['add']; //Displaying Session message
                  unset($_SESSION['add']); //Removing Session message
              }

              if(isset($_SESSION['delete']))
              {
                  echo $_SESSION['delete']; //Displaying Session message
                  unset($_SESSION['delete']); //Removing Session message
              }
              if(isset($_SESSION['update']))
              {
                  echo $_SESSION['update'];
                  unset($_SESSION['update']);
              }
              if(isset($_SESSION['user-not-found']))
              {
                  echo $_SESSION['user-not-found'];
                  unset($_SESSION['user-not-found']);
              }
              if(isset($_SESSION['password-did-not-match']))
              {
                  echo $_SESSION['password-did-not-match'];
                  unset($_SESSION['password-did-not-match']);
              }
              if(isset($_SESSION['change-password']))
              {
                  echo $_SESSION['change-password'];
                  unset($_SESSION['change-password']);
              }

           ?>
           <br><br><br>
          <!-- Button to Add Admin -->
          <a href="add-admin.php"class="btn-primary">Add Admin</a>

        <br /><br /><br />


            <table class="tbl-full">
              <tr>
                <th>S.N</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
              </tr>


              <?php
                  //Query to get all Admin
                  $sql = "SELECT * FROM tbl_admin";
                  //Execute the Query
                  $res = mysqli_query($conn, $sql);

                  //Check whether the query is executed or not
                  if($res==TRUE)
                  {
                      //Count rows to check whether we have data in database or not
                      $count = mysqli_num_rows($res); //Function to get all the raws in Database

                      $sn=1; //create a variable and the value

                      //Check the num of rows
                      if($count>0)
                      {
                        //We have data in database
                        while($rows=mysqli_fetch_assoc($res))
                        {
                                //Using while loop to get all the data from Database
                                //And while loop will run as long as we have data in Database

                                //Get indivual Data
                                $id=$rows['id'];
                                $full_name=$rows['full_name'];
                                $username=$rows['username'];

                                //Display the values in our table

                              ?>  <tr>
                                  <td> <?php echo $sn++; ?></td>
                                  <td><?php echo $full_name; ?></td>
                                  <td><?php echo $username; ?></td>
                                  <td>
                                    <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>"class="btn-primary">Change Password</a>
                                    <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>"class="btn-secondary">Update Admin</a>
                                    <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>"class="btn-danger">Delete Admin</a>
                                  </td>
                                </tr>

                              <?php

                        }
                      }

                      else
                       {
                            // We  do not have data in database
                       }
                   }
         ?>


          </table>

        </div>
      </div>
      <!--main content section Ends -->

  <?php include('partials/footer.php'); ?>
