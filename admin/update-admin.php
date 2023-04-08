<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>

        <br><br>

        <?php
            //1.Get the ID of the selected admin
            $id=$_GET['id'];

            //2.Create SQL Query to get the details
            $sql="SELECT * FROM tbl_admin WHERE id=$id";

            //Execute the Query
            $res = mysqli_query($conn, $sql);

            //Check whether the query is executed or not
            if($res==true)
            {
              //check whether the data is available or not
              $count = mysqli_num_rows($res);
              //check whether we have admin data or not
              if($count==1)
              {
                //Get the details
                //echo "Admin Available";
                $row=mysqli_fetch_assoc($res);

                $full_name = $row['full_name'];
                $username = $row['username'];
              }
              else
              {
                //Redirect to manage Admin Page
                header("location:".SITEURL.'admin/manage-admin.php');
              }
            }

         ?>


        <form action="" method="post">

          <table class="tbt-30">
              <tr>
                <td>Full Name </td>
                <td>
                    <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                </td>
              </tr>

              <tr>
                <td>Username: </td>
                <td>
                    <input type="text" name="username" value="<?php echo $username; ?>">
                </td>
              </tr>

              <tr>
                  <td colspan="2">
                      <input type="hidden" name="id" value="<?php echo $id; ?>">
                      <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                  </td>
              </tr>

          </table>

        </form>
    </div>
</div>

<?php

    //check whether the submit Button is clicked or not
    if(isset($_POST['submit']))
    {
      //echo "Button Clicked";
      //Get all the values from the form to update
      $id = $_POST['id'];
      $full_name =$_POST['full_name'];
      $username = $_POST['username'];

      //Create a SQL to Update Admin
      $sql = "UPDATE tbl_admin SET
      full_name = '$full_name',
      username = '$username'
      WHERE id='$id'
      ";

      //Execute the query
      $res = mysqli_query($conn, $sql);

      //Check whether the query is executed Successfully or not
      if($res==true)
      {
           //Querry Executed and Admin Updated
           $_SESSION['update'] = "<div class='success'>Admin Updated Successfully.</div>";
           // Redirect to manage Admin Page
             header("location:".SITEURL.'admin/manage-admin.php');
      }
      else
      {
        //Failed To update Admin
        $_SESSION['update'] = "<div class='error'>Failed.</div>";
        // Redirect to manage Admin Page
          header("location:".SITEURL.'admin/manage-admin.php');
      }
    }

 ?>

  <?php include('partials/footer.php'); ?>