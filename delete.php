<?php
	$id=$_GET['id'];
	include('config.php');
	mysqli_query($con,"delete from `users` where id='$id'");
	header('location:dashbord.php');
?>