<?php

    $CONTROLLERS_DIR = dirname( __DIR__ );
    $APP_DIR = dirname( $CONTROLLERS_DIR );

	require_once $CONTROLLERS_DIR . '/session.php';

	if(!$userLogged) {
		header('Location: ../');
		exit;
	}
	
?>

<!DOCTYPE html>
<html>
	<head>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">


		<base href="http://localhost/startuppuccino-website/source-code/">

		<link rel="stylesheet" type="text/css" href="app/assets/css/settings.css">
		<title>Account Settings - Startuppuccino</title>
	
		
        <?php include $APP_DIR . '/views/extra_head_html.php'; ?>

	
	</head>
	<body>
		
		<?php include $APP_DIR . '/views/header.php'; ?>

		<main>

			<?php require $CONTROLLERS_DIR . '/account_settings.php'; ?>

		</main>

		<?php include $APP_DIR . '/views/footer.php'; ?>

	</body>
</html>