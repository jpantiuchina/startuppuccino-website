<?php

	require_once '../app/models/session.php';

	// Redirect to home if user is not logged
	if(!$userLogged){
		header("Location: ../");
		exit;
	}

	// Account id
	$account_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

?>

<!DOCTYPE html>
<html>
	<head>

		<link rel="stylesheet" type="text/css" href="../app/assets/css/form.css">
		<link rel="stylesheet" type="text/css" href="../app/assets/css/ideas.css">
		<link rel="stylesheet" type="text/css" href="../app/assets/css/general.css">
		<link rel="stylesheet" type="text/css" href="../app/assets/css/listview.css">
		<title>Ideas - Startuppuccino</title>

	</head>
	<body>
		
		<?php include '../app/views/header.php'; ?>
		
		<main>

			<?php 

				// Account id
				$account_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

				// Include and Initialize Ideas Functions
				require_once '../app/models/Ideas_Functions.php';
				$ideas_func = new Ideas_Functions($account_id);


				if (!($ideas = $ideas_func->getAllIdeas())){
					return "No ideas found...";
				}

				$isStudent = (isset($_SESSION['role']) && $_SESSION['role']=="student");
				$isMentor = (isset($_SESSION['role']) && $_SESSION['role']=="mentor");

			?>


			<section class="list_view">
				<?php echo include 'idea_view_switch.php'; ?>
			</section>

		</main>

		<?php include '../app/views/footer.php'; ?>

		<script src="../app/assets/js/ideas.js"></script>

	</body>
</html>