<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
         <h1>Manage Book</h1>

         <br /><br/>
         <?php
            if (isset($_SESSION['book']))
            {
              echo $_SESSION['book'];
              unset($_SESSION['book']);
            }

          ?>

         <table class="tbl-full">
           <tr>
             <th>S.N</th>
             <th>destination</th>
             <th>price</th>
             <th>qty</th>
             <th>total</th>
             <th>book_date</th>
             <th>status</th>
             <th>customer_name</th>
             <th>contact</th>
             <th>email</th>
             <th>address</th>
             <th>actions</th>
           </tr>
           <?php
              //get the data from the book table
              $sql = "SELECT *FROM tbl_book ORDER BY id DESC";//display the last book first
              //excute the query
              $res = mysqli_query($conn, $sql);
              //count the rows
              $count = mysqli_num_rows($res);
              $sn = 1; // create a  serial number and set its initial value as one
              if ($count>0)
              {
                // book available
                while ($row = mysqli_fetch_assoc($res))
                {
                  // get all the order details
                  $id = $row['id'];
                  $destination = $row['destination'];
                  $price = $row['price'];
                  $qty = $row['qty'];
                  $total = $row['total'];
                  $book_date = $row['book_date'];
                  $status = $row['status'];
                  $customer_name = $row['customer_name'];
                  $customer_contact = $row['customer_contact'];
                  $customer_email = $row['customer_email'];
                  $customer_address = $row['customer_address'];
                  ?>
                  <tr>
                    <td><?php echo $sn++; ?></td>
                    <td><?php echo $destination; ?></td>
                    <td><?php echo $price; ?></td>
                    <td><?php echo $qty; ?></td>
                    <td><?php echo $total; ?></td>
                    <td><?php echo $book_date; ?></td>

                    <td>
                      <?php
                      //ordererd,On delivery, Delivered,cancelled
                      if ($status=="Booked")
                      {
                        echo "<label>$status</label>";
                      }
                      elseif ($status=="On process")
                      {
                        echo "<label style='color:orange;'>$status</label>";
                      }
                      elseif ($status=="Paid")
                      {
                        echo "<label style='color:green;'>$status</label>";
                      }
                      elseif ($status=="Cancelled")
                      {
                        echo "<label style='color:red;'>$status</label>";
                      }

                       ?>
                    </td>

                    <td><?php echo $customer_name; ?></td>
                    <td><?php echo $customer_contact; ?></td>
                    <td><?php echo $customer_email; ?></td>
                    <td><?php echo $customer_address; ?></td>
                    <td>
                      <a href="<?php echo SITEURL; ?>admin/update-book.php?id=<?php echo $id;?>" class="btn-secondary">Update Booking</a>
                    </td>
                  </tr>
                  <?php

                }

              }
              else
              {
                // book not available...
                echo "<tr><td colspan='12' class='error'> book not available</td></tr>";
              }
            ?>


         </table>
    </div>

</div>

<?php include('partials/footer.php'); ?>
