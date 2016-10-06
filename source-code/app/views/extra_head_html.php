
<?php

	$dev_local_host = "http://localhost/startuppuccino-website/source-code/";
	$absolute_host_uri = $_SERVER['HTTP_HOST'] === "localhost" ? $dev_local_host : $_SERVER['HTTP_HOST'];

	// HOTJAR --> HEATMAP
	include $absolute_host_uri.'/app/vendor/hotjar_tracking_code.php'; 

	// GOOGLE ANALYTICS
	

?>