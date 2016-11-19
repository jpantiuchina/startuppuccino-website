<?php
	
	require_once '../../../app/models/session.php';

	// Give the access to this page only to educators
	if(!$userLogged || $_SESSION['role']!="educator"){
		header("Location: ../../../");
		exit;
	}



	$mails_sent = [];

	if(isset($_POST['submit_mail'])){

		// Check for required user inputs
		if( !empty($_POST['from']) &&
			!empty($_POST['object']) &&
			!empty($_POST['message']) ) {

			$from = $_POST['from'];
			$object = $_POST['object'];
			$message = $_POST['message'];


			require '../../../app/models/db_connect.php';

			// List all the mentors

			$query = "SELECT email FROM "._T_ACCOUNT." WHERE role='mentor';";

			if($mentors = mysqli_query($dbconn,$query)){

				while($mentor = mysqli_fetch_assoc($mentors)){

					if(mail(
							$mentor['email'], 
							$object,
							$message,
							"From: ".$from
						)) {

						$mails_sent[] = $mentor['email'];

					} else {

						echo "Error sending the email to: ".$mentor['email'];

					}
					
				}

			}

		} else {

			die("Some required user inputs have been missing.");

		}

	}

?>


<!DOCTYPE html>
<html>
	<head>

		<link rel="stylesheet" type="text/css" href="../../../app/assets/css/general.css">
		<title>Mail Manager - Startuppuccino</title>

		<style>main{padding:20px;}input,textarea{margin:5px}</style>

	</head>
	<body>
		
		<main>

			<a href="../../../">Startuppuccino - home</a>

			<br>

				<?php 
					if(!empty($mails_sent)){
						echo "<p><b>Mail correctly sent to:</b></p>";
						foreach ($mails_sent as $mail) {
							echo $mail."<br>";
						}
					}
				?>

			<br>

			<h1>Mail manager - send emails to <b><u>ALL MENTORS</u></b></h1>

			<form action="index.php" method="post">

				<label for="from">Sender email (From: ...)</label>
				<input type="email" name="from" placeholder="info@startuppuccino.com" value="info@startuppuccino.com" required />
				<br>

				<label for="object">Email object</label>
				<input type="text" name="object" placeholder="Course Information" required />
				<br>

				<label for="message">Message</label>
				<textarea name="message" required ></textarea>
				<br>

				<input type="submit" name="submit_mail" value="Send email" />

			</form>
			
		</main>

		<script src="../../../app/assets/js/startuppuccino.js"></script>
		<script src="../../../app/assets/js/educators.js"></script>

	</body>
</html>