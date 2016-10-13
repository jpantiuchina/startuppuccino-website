
<?php

    if(!defined("RELATIVE_PATH")){
        define("RELATIVE_PATH", "..");
    }

	// Helper function -> print uri with the correct relative path
    function includeUri($link){
        include RELATIVE_PATH . $link;
    }

	// HOTJAR --> HEATMAP
	//includeUri('/app/vendor/hotjar_tracking_code.php'); 

	// GOOGLE ANALYTICS
	//includeUri('/app/vendor/google_analytics_tracking_code.php'); 

?>