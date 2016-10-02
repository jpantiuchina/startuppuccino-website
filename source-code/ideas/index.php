<?php

	require_once '../app/models/session.php';

	// Redirect to home if user is not logged
	if(!$userLogged){
		header("Location: ../");
		exit;
	}

	// Account id
	$account_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
	$isStudent = (isset($_SESSION['role']) && $_SESSION['role']=="student");
	$isMentor = (isset($_SESSION['role']) && $_SESSION['role']=="mentor");

	// Include and Initialize Ideas Functions
	require_once '../app/models/Ideas_Functions.php';
	$ideas_func = new Ideas_Functions($account_id);

	$ideas = [];

?>

<!DOCTYPE html>
<html>
	<head>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="stylesheet" type="text/css" href="../app/assets/newcss/ideas.css">
		<title>Ideas - Startuppuccino</title>

	</head>
	<body>
		
		<?php $page_title = 'Ideas'; ?>

		<?php include '../app/views/header_new.php'; ?>
		
		<main>

			<?php if ( !($ideas = $ideas_func->getAllIdeas()) && $_SESSION['ideas_phase'] != "1" ){ ?>
			
				<section><p>No ideas found...</p></section>
			
			<?php } else { ?>

				<section>
					<?php echo include 'idea_view_switch.php'; ?>
				</section>

			<?php } ?>

		</main>

		<?php include '../app/views/footer.php'; ?>

		<script src="../app/assets/js/ideas.js"></script>

	</body>
</html>