<?php

    $CONTROLLERS_DIR = dirname( __DIR__ );
    $APP_DIR = dirname( $CONTROLLERS_DIR );


    require_once $CONTROLLERS_DIR . '/session.php';

	// Redirect to landing page if user is not logged
	if(!$userLogged){
		header("Location: ../");
		exit;
	}

	$currentPage = "home";

?>

<!DOCTYPE html>
<html>
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<base href="http://localhost/startuppuccino-website/source-code/">

	<title>Home - Startuppuccino</title>
	<link rel="stylesheet" type="text/css" href="app/assets/css/home.css">

	<script type="text/javascript">
		var STARTUPPUCCINO_USER = {
				id : "<?php echo $_SESSION['id']; ?>",
				avatar : "<?php echo empty(trim($_SESSION['avatar'])) ? 'avatar.svg' : $_SESSION['avatar']; ?>"
			};
	</script>

    <?php include $APP_DIR . '/views/extra_head_html.php'; ?>


</head>
<body>

	<?php include $APP_DIR . '/views/header.php'; ?>

	<main>

		<?php include $CONTROLLERS_DIR . '/course_sessions.php'; ?>

	</main>

	<?php include $APP_DIR . '/views/footer.php'; ?>

	<script src="app/assets/js/home.js"></script>

</body>
</html>