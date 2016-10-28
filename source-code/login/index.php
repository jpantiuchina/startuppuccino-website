<?php 

	require_once '../app/models/session.php'; 

	if ($userLogged) {
		header('Location: ../');
		exit;
	}

	if (isset($_POST['login'])){

 		$login_email = $_POST['email'];
 		$login_password = md5($_POST['password']);

 		$isPermaLogin = isset($_POST['permalogin']) && $_POST['permalogin'] === "y";

 		include '../app/controllers/login.php';
		
	} else {

		// initialize variable to prevent to show the error message
		$loginOk = true;

?>
<!DOCTYPE html>
<html>
	<head>
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>Startuppuccino - Login</title>
		<link rel="stylesheet" type="text/css" href="../app/assets/newcss/login.css">

		
        <?php include '../app/views/extra_head_html.php'; ?>


	</head>
	<body>

		<?php $page_title = "Login"; ?>
		<?php $currentPage = 'login' ?>
		<?php include '../app/views/header.php'; ?>

		<main>

			<h1>Login</h1>

			<?php include '../app/views/login_form.php'; ?>

		</main>

		<?php include '../app/views/footer.php'; ?>

	</body>
</html>

<?php } ?>