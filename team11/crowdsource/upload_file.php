<?php

include "db_connect.php";
include "functions.php";

session_start();

if(isset($_Get['error'])) {
	echo 'Error: Cannot log in at this time';
} else {

	if (login_check($db) == true) {
		//protected page content


		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);
		if ((($_FILES["file"]["type"] == "image/gif")
					|| ($_FILES["file"]["type"] == "image/jpeg")
					|| ($_FILES["file"]["type"] == "image/jpg")
					|| ($_FILES["file"]["type"] == "image/pjpeg")
					|| ($_FILES["file"]["type"] == "image/x-png")
					|| ($_FILES["file"]["type"] == "image/png"))
		   )//&& ($_FILES["file"]["size"] < 20000)
			   //&& in_array($extension, $allowedExts)) 
		   {
			   if ($_FILES["file"]["error"] > 0) {
				   echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
			   } else {
				   echo "Upload: " . $_FILES["file"]["name"] . "<br>";
				   echo "Type: " . $_FILES["file"]["type"] . "<br>";
				   echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
				   echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

					   $filename = "upload/".$_SESSION["username"].".jpg";
					   move_uploaded_file($_FILES["file"]["tmp_name"], $filename);
					   echo "Stored in: " . $filename;
					   $query = "insert into image (img_path) values (?)"; 
					   $stmt = $db->prepare($query);
					   $stmt->bind_param("s", $filename);
					   $stmt->execute();
					   echo "<br>".$stmt->affected_rows." picture saved.";
					   $stmt->close();

					   //get user id and image id
					   $getUserImage = $db->prepare("
							   SELECT id, (SELECT id FROM image WHERE img_path = ?) AS imgID
							   FROM client WHERE username = ?");
					   $getUserImage->bind_param('ss', $filename, $_SESSION['username']);
					   $getUserImage->execute();
					   $getUserImage->store_result();
					   $getUserImage->bind_result($user_id, $image_id);
					   $getUserImage->fetch();
					   $getUserImage->close();

					   //update the user's profile picture
					   $change_image = $db->prepare("UPDATE profile SET image_id = ? WHERE user_id = ?");  
					   $change_image->bind_param("ii", $image_id, $user_id);
					   $change_image->execute();
					   $change_image->close();

			   		   header('Location: ./profile.php');
			   }

		   } else {
			   echo "Invalid file";
		   }

	} else {
		echo "You are not authorized to view this page!";
		header('Location: ./login.php');
	}
}

?>			
