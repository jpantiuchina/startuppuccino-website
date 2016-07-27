<?php 


require_once './app/models/session.php';

// Redirect to /home/ if user is logged
// Redirect to /about/ if user is not logged
if($userLogged){
	header("Location: ./home/");
} else {
	header("Location: ./about/");
}


?>