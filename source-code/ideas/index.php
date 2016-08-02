<?php

	require_once '../app/models/session.php';

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

			<?php // If user is logged and current phase: 1, students can create new ideas ?> 
			<?php if ($_SESSION['ideas_phase']==1 && $_SESSION['role']=="student"){ ?>

			<div class="new_idea__button">
				<span onclick="showIdeaForm()">NEW IDEA</span>
		  	</div>
		  	<section id="new_idea__section">
		  		<div class="new_idea__button">
		  			<span  onclick="hideIdeaForm()">CANCEL</span>
		  		</div>
		  		<?php include 'idea_form.php'; ?>
		  	</section>
			
			<?php } ?>


			<section class="list_view">
				<?php echo include 'idea_view.php'; ?>
			</section>

		</main>

		<?php include '../app/views/footer.php'; ?>

		<script src="../app/assets/js/ideas.js"></script>

	</body>
</html>