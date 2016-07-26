<?php 

	require_once '../app/models/session.php'; 

	if ($userLogged) {
		header('Location: ../');
		exit;
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Startuppuccino - Login</title>
		<link rel="stylesheet" type="text/css" href="../app/assets/css/form.css">
		<link rel="stylesheet" type="text/css" href="../app/assets/css/general.css">
	</head>
	<body>

		<?php 
			
			include '../app/views/header.php';

		 	if (isset($_POST['login'])){ 

		 		include 'login.php'; 
	
		  		// javascript (client) redirect to home page once the user is logged
		    	if ($loginOk){
				   	echo "<script>window.location='../'</script>";
		    	} else {
			    	include 'login_form.php';
		    	}
		  
			} else {

				$loginOk = true; // initialize variable to prevent to show the error message
				include 'login_form.php';

			}
		
			include '../app/views/footer.php'; 

		?>

	</body>
</html>