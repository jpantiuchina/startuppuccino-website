<?php

	require_once '../app/models/session.php';

	// Instantiate the Team Functions (without addressing any specific team)
	require_once '../app/models/Team_Functions.php';
	$team_func = new Team_Functions($_SESSION['id'],NULL);

	if ($teams = $team_func->getAllTeams()){

		include '../app/views/team_list.php';

	} else {

		echo "No teams here!";

	}

?>