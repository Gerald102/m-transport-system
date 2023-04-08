<?php include('partials-front/menu.php'); ?>
	<!-- header section ends -->

<div class="heading" style="background: url('images/pngtree.jpg')" ;>
	<h1>destinations</h1>
</div>


<!-- Destination Place Section Starts Here -->


    <section class="Destination-Place">
        <div class="container">
        <h2 class="text-center">Destination Place</h2>

        

            <?php
                //display destinations that are active
                $sql ="SELECT * FROM tbl_destination WHERE active='Yes'";

                //execute the query
                $res=mysqli_query($conn, $sql);

                //count rows
                $count = mysqli_num_rows($res);

                //check whether destination available or not
                if($count>0)
                {
                  //destination available
                  while($row=mysqli_fetch_assoc($res))
                  {
                    //Get the values
                    $id=$row['id'];
                    $title=$row['title'];
                    $description=$row['description'];
                    $price=$row['price'];
                    $image_name=$row['image_name'];
                    ?>

                    <div class="Destination-Place-box">
                        <div class="Destination-Place-img">
                          <?php
                            //check whether image available or not
                            if($image_name=="")
                            {
                              //image not available
                              echo "<div class='error'>Image Not Available</div>";
                            }
                            else
                            {
                              //image available
                              ?>
                              <img src="<?php echo SITEURL; ?>images/destination/<?php echo $image_name; ?>" alt="" class="img-responsive img-curve">
                              <?php
                            }
                           ?>

                        </div>

                        <div class="Destination-Place-desc">
                            <h4><?php echo $title; ?></h4>
                            <p class="Trip-price">Ksh.<?php echo $price; ?></p>
                            <p class="Journey-detail">
                                <?php echo $description; ?>
                            </p>
                            <br>

                            <a href="<?php echo SITEURL; ?>book.php?destination_id=<?php echo $id; ?>&title=<?php echo $title; ?>&price=<?php echo $price; ?>&image_name=<?php echo $image_name; ?>" class="btn btn-primary">Book Now</a>

                        </div>
                    </div>

                    <?php

                  }
                }
                else
                {
                  //destination not available
                  echo "<div class='error'>Destination Not Available</div>";
                }
             ?>



            <div class="clearfix"></div>



        </div>

    </section>
    
<!-- Destination Place Section Ends Here -->


    



<!-- footer section starts -->
<?php include('partials-front/footer.php'); ?>
</body>
</html>

