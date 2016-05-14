<?php include '../assets/php/session.php' ?>
<?php

$accountName       = 'Jevgenija Pantiuchina';
$accountRole       = 'Mentor';
$accountBackground = 'IT';
$accountAbout = 'I am one of the developers of this website. 
Found a bug or a mistake? Please tell me: Jevgenija.Pantiuchina@unibz.it.';

?>
<!DOCTYPE html>
<html>
	<head>

		<link rel="stylesheet" type="text/css" href="../assets/css/form.css">
		<link rel="stylesheet" type="text/css" href="../assets/css/general.css">
		<title><?= htmlspecialchars($accountName) ?> - Startuppuccino</title>

	</head>
	<body>

		<?php include '../assets/php/header.php'; ?>


		<h1><?= htmlspecialchars($accountName) ?></h1>

		<p><strong><?= htmlspecialchars($accountRole) ?></strong></p>

		<p><?= htmlspecialchars($accountBackground) ?></p>


		<p style="white-space: pre-line"><?= htmlspecialchars($accountAbout) ?></p>



		<?php include '../assets/php/footer.php'; ?>

	</body>
</html>