<?php include('partials-front/menu.php'); ?>
	<!-- header section ends -->


    <!-- book section starts -->

    <!-- destination sEARCH Section Starts Here -->

<?php
        // check whethe destination id is set or not
        if (isset($_GET['destination_id']))
        {
        //get the destination_id id and the selected details
        $destination_id = $_GET['destination_id'];
        //get the details of the selected destination
        $sql = "SELECT *FROM tbl_destination WHERE id = $destination_id";
        // Excute the query
        $res = mysqli_query($conn, $sql);
        //count the rows
        $count = mysqli_num_rows($res);
        // check whether the data is available or not
        if ($count == 1)
        {
          // data is available
          //get the data from the database
          $row = mysqli_fetch_assoc($res);
          $title = $row['title'];
          $price = $row['price'];
          $image_name = $row['image_name'];
        }
        else
        {
          //data is not available
          //redirect to home page
          header('location:'.SITEURL);
        }
        }
        else
        {
        // redirect to home page
        header('location:'.SITEURL);
        }
    ?>
<!-- destination sEARCH Section Starts Here -->

<section class="booking">
  <h1 class="heading-title">confirm your Booking!</h1>
   <div class= "flx">

            <form action="" method="POST" class="Book">
                <fieldset>
                    <legend>Selected Destination</legend>

                    <div class="Destination-Place-img">

                      <?php
                          //check whether the image is available or not
                          if ($image_name == "")
                          {
                            // image is not available
                            echo "<div class='error'>Image is not available</div>";
                          }
                          else
                          {
                            // image is available
                            ?>
                            <img src="<?php echo SITEURL;?>images/destination/<?php echo $image_name; ?>" alt="Destination.jpg" class="img-responsive img-curve">
                            <?php
                          }
                       ?>
                    </div>

                    <div class="Destination-Place-desc">
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="destination" value="<?php echo $title ?>">

                        <p class="Trip-price">Ksh.<?php echo $price; ?></p>
                          <input type="hidden" name="price" value="<?php echo $price ?>">

                        <div class="Book-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>

                    </div>
                </fieldset>
          

                <h3>Ticket Details</h3>
              <div class="flex">  
                <div class="inputBox">
                  <span>Full Name :</span>
                  <input type="text" placeholder="Gerald Mungai" name="full-name" required>
                </div>

              
                <div class="inputBox">
                  <span>Phone Number :</span>
                  <input type="tel" placeholder="enter your number" name="contact" required>
                </div>


                <div class="inputBox">
                  <span>Email :</span>
                  <input type="email" placeholder="gerald@gmail.com" name="email" required>
                </div>


                <div class="inputBox">
                  <span>Address :</span>
                  <input type="address" rows="5" placeholder="enter your address" name="address" required>
                </div>
              </div>
              <input type="submit" name="submit" value="Confirm Book" class="btn btn-primary">
       
      </div>        
     </form>

        <?php
//check whether button submit is clicked or not
if (isset($_POST['submit']))
{
  // get all the details from the form
  $destination = $_POST['destination'];
  $price = $_POST['price'];
  $qty = $_POST['qty'];
  $total = $price * $qty; // total = price * qty
  $book_date = date("y-m-d h:i:sa"); // book date
  $status = "Booked"; // Booked, on process, Paid, cancelled
  $customer_name = $_POST['full-name'];
  $customer_contact = $_POST['contact'];
  $customer_email = $_POST['email'];
  $customer_address = $_POST['address'];
  // save the data in the database
  // create sql query to save the data
  $sql2 = "INSERT INTO tbl_book SET
      destination = '$destination',
      price = $price,
      qty = $qty,
      total = $total,
      book_date = '$book_date',
      status = '$status',
      customer_name = '$customer_name',
      customer_contact = '$customer_contact',
      customer_email = '$customer_email',
      customer_address = '$customer_address'
  ";
  // execute the query
  $res2 = mysqli_query($conn, $sql2);
  //check whether the query is excuted or not
  if ($res2==true)
  {
    // query is excuted and ordre is saved
    $_SESSION['book'] = "<div class='success text-center'>Ticket booked successfully. </div>";
    header('location:'.'mpesa.php');
  }
  else
  {
    //query is not excuted and order not saved
    $_SESSION['book'] = "<div class='error text-center'>Failed to book. </div>";
    header('location:'.SITEURL);
  }

}
?>

    </div>
</section>
<!-- Destination Booking Section Ends Here -->


    <!-- Destination Booking Section Ends Here -->


    <!-- book section ends -->


    
<!-- footer section starts -->
<?php include('partials-front/footer.php'); ?>
</body>
</html>

