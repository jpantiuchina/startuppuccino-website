<?php

	require_once '../app/models/session.php';

	// Redirect to home if user is not logged
	if(!$userLogged){
		header("Location: ../");
		exit;
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Home - Startuppuccino</title>
	<link rel="stylesheet" type="text/css" href="../app/assets/newcss/home.css">
</head>
<body>

	<?php include '../app/views/header_new.php'; ?>

	<main>

		<p class="page_title">Lectures</p>

		<section>
			
			<div class="session" id="session_1">

				<div class="description">
					<h3>Week 2</h3>
					<p>It is important to build teams in which students from  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
				</div>

				<div class="resources">
					<h3>Resources</h3>
					<ul>
						<li>
							<a href="../app/api/download/?f=Team_building.pdf" target="_blank">
								<span class="icon pdf"></span>Team_building.pdf
							</a>
						</li>
						<li>
							<a href="../app/api/download/?f=Team_building_2.pdf" target="_blank">
								<span class="icon pdf"></span>Team_building_2.pdf
							</a>
						</li>
					</ul>
				</div>

				<!--

				<div class="comments">

					<span class="toggle_button" onclick="Sp.layout.toggleComments('1')">comments (0)</span>
					<div class="comments_wrapper">

					</div>

				</div>

				-->

			</div>

		</section>

	</main>

	<?php include '../app/views/footer.php'; ?>

</body>
</html>