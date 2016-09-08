<?php

	require_once '../models/Search_Functions.php';
	$search_func = new Search_Functions();

	echo $search_func->getAll(); 

?>