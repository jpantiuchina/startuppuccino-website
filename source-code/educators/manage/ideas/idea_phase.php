<?php
	
	require_once '../../../app/models/session.php';

	// Give the access to this page only to educators
	if(!$userLogged || $_SESSION['role']!="educator"){
		header("Location: ../../../");
		exit;
	}

	$configs_file = "../../../app/configs/configs.json";

	// Get current phase
	$configs = json_decode(file_get_contents($configs_file),true);

?>


<?php

	if(isset($_POST['change_phase'])){

		if(isset($_POST['phase']) && (!empty($_POST['phase']) || $_POST['phase']==='0')){

			// save new value of "phase"
			$configs["functionalities"]["ideas"]["phase"] = $_POST["phase"];
			$save = file_put_contents($configs_file, json_encode($configs));

			if($save){
				// TODO -> force delete of all users logged in
				//...
			}

		}

	}

?>

<h3>Current phase: <?php echo $configs["functionalities"]["ideas"]["phase"];?></h3>

<form action="idea_phase.php" method="post">
	<label>Ideas Phase</label><br>
	<select name="phase" require>
		<option disabled="" selected="">Select a phase</option>
		<option value="0">Default</option>
		<option value="1">Phase 1</option>
		<option value="2">Phase 2</option>
		<option value="3">Phase 3</option>
	</select>
	<input type="submit" name="change_phase" value="SAVE" />
</form>