<?php
	//include constants page
	include('../config/constants.php');



	if(isset($_GET['id']) && isset($_GET['image_name']))
	{
		//1. process to delete
		$id = $_GET['id'];
		$image_name = $_GET['image_name'];


		//2. remove the image if available
		//check whether the image is available or not and delete if only available
		if($image_name != "")
		{
			//it has the image and need to be deleted
			//get the image path
			$path = "../images/destination/".$image_name;

			//remove image file from the folder
			$remove = unlink($path);

			// check whether the image is removed or not
			if($remove == false)
			{
				//failed to remove the image
				$_SESSION['upload'] = "<div class ='error'>failed to remove the image from the file</div>";
				//redirect to manage vehicle
				header('location:'.SITEURL.'admin/manage-destination.php');
				//stop the process of deleting
				die();
			}
		}

		//3. delete the vehicle from the database
		$sql = "DELETE FROM tbl_destination where id = $id";
		// execute the query
		$res = mysqli_query($conn, $sql);
		// check whether the query is executed or not and set the sessioin message respectively
		//4. Redirect to manage vehicle with session message
		if ($res == true)
		{
			// destination deleted
			$_SESSION['delete'] = "<div class ='success'>destination deleted successfully</div>";
			header('location:'.SITEURL.'admin/manage-destination.php');
		}
		else
		{
			//fail to delete
			$_SESSION['delete'] = "<div class ='error'>failed to delete destination</div>";
			header('location:'.SITEURL.'admin/manage-destination.php');
		}




	}
	else
	{
		//Redidrect to manage destination
		$_SESSION['unauthorized'] = "<div class ='error'>Unauthorized Access</div>";
		header('location:'.SITEURL.'admin/manage-destination.php');
	}


?>
