<?php

	/* Really bad solution ... to refactor asap */

	define("DEV_HOST_NAME","http://localhost/startuppuccino-website/source-code/");

	if($_SERVER['HTTP_HOST'] === "localhost"){

		define("URI_", DEV_HOST_NAME);

	} else {
	
		define("URI_", $_SERVER['HTTP_HOST']);

	}

?>