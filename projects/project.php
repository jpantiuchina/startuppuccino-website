<?php include '../assets/php/session.php' ?>
<?php

$projectTitle       = 'Startuppuccino';
$projectDescription = 'Startuppuccino is a project whose vision is to provide startups the guidance they may need in their early steps.  

On the portal, startuppers and enterpreneurs can find every direct guidance through the help of our mentors team, specialized personal ready to direct people into the correct direction, as well as a selection of useful web tools they can use to improve their working experience.  

Startuppuccino is a free service, born during the Lean Startup course and sponsored by Unibz.  

Our website: www.startuppuccino.com';


?>
<!DOCTYPE html>
<html>
	<head>

		<link rel="stylesheet" type="text/css" href="../assets/css/form.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/general.css">
		<title><?= htmlspecialchars($projectTitle) ?> - Startuppuccino</title>

	</head>
	<body>

		<?php include '../assets/php/header.php'; ?>


		<h1><?= htmlspecialchars($projectTitle) ?></h1>

		<p style="white-space: pre-line"><?= htmlspecialchars($projectDescription) ?></p>


		<h3>Members</h3>
		<ol>
			<li><a href="/people/1">Jevgenija Pantiuchina</a></li>
			<li><a href="/people/4">Marco Mondini</a></li>
			<li><a href="/people/3">Dron Khanna</a></li>
		</ol>

		<?php include '../assets/php/footer.php'; ?>

	</body>
</html>

