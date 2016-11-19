<?php

	/*
    	USAGE EXAMPLE

		
        require 'dump_router.php';	
		

		// OPTIONAL SETTINGS

	    // Optional
	    Dump_Router::setControllersExtension('.your_controller_extension'); // Default is ".php"
	  
	    // Optional
	    Dump_Router::setDeaultController('not_found.php'); // Default is "404.php"



		// SET ROUTES

	    // Second parameter is optional except for the home/landing
	    Dump_Router::route('/',[
		  'controller' => "landing"
		]);

	    Dump_Router::route('about'); // Default controller name is the path segment name

	    Dump_Router::manyRoute(['about','login','register']); // Set as multiple routes as the command above
	    
	    Dump_Router::route('shop', [
	      'pretty_parameters' => ['category', 'product'] // Optional
	    ]);

	    Dump_Router::route('product',[
	      'controller' => "product_box" // Custom controller, to specify different controller name
	    ])
	    
	    

		// TRIGGER ROUTER

	    // Second parameter is optional
	    Dump_Router::render($_SERVER['REQUEST_URI']);
	    
	    Dump_Router::render($_SERVER['REQUEST_URI'], $controllers_directory_path); // Default dir is "./app/controllers/"


	  */



	  /*
		
		MINIMAL EXAMPLE

		require 'dump_router.php';

		Dump_Router::route('/',[
		  'controller' => "landing"
		]);

		Dump_Router::render($_SERVER['REQUEST_URI']);

	  */
	

	/**
	* Dump Router class
	* Evaluate uri and load the right controller with a switch based on path segments
	* @public methods: route(), render(), manyRoute(), setDefaultController(), setControllersExtension()
	*/
	class Dump_Router {
		
		/**
		 * Controllers dir
		 */
		private static $controllers_dir = "./app/controllers/";

		/**
		 * Default controller file extension
		 */
		private static $controllers_ext = ".php";

		/**
		 * Set here a deafult controller to load in case of errors
		 */
		private static $default_controller = "404.php";
		private static $default_error_message = "Ops, nothing is here!";

		/**
		 * Declare an empty array "routes" to store all the routes paths
		 */
		private static $routes = [];

		/**
		 * Set default controller
		 */
		public static function setDefaultController($value){
			self::$default_controller = $value;
		}

		/**
		 * Set default controller
		 */
		public static function setControllersExtension($value){
			self::$controllers_ext = $value;
		}

		/**
		 * Add new route to the collection
		 */
		public static function route($path_segment, $route_data = null) {
			// When route_data is not specified, 
		    // use the same path_segment as controller name
		    if ($route_data === null) {
		    	$route_data = ['controller' => $path_segment];
		    } else if (!isset($route_data['controller'])){
		    	$route_data['controller'] = $path_segment;	
		    }
			// Store the new route
			self::$routes[$path_segment] = $route_data;
		}

		/**
		 * Set multiple simple route
		 */
		public static function manyRoute($routes_arr) {
			foreach ($routes_arr as $route) {
				self::route($route);
			}
		}

		/**
		 * Evaluate URI and include the right controller
		 */
		public static function render($uri, $controllers_dir = null) {
			
			// Set the controllers dir
			if ($controllers_dir === null) {
				$controllers_dir = self::$controllers_dir;
			}

			// @string uri to @array with 'path' and 'parameters'
			$uri = self::parseUriPath($uri);
			// @array of path segments
			$path = self::parseUriSegments($uri['path']);

			$controller_name = null;

			foreach (self::$routes as $route_segment => $route_data) {

				if ($path[0] == $route_segment) {
					
					$controller_name = $route_data['controller'];
					// Set parameters in the $_GET array
					self::setGetParameters($uri['parameters']);
					// Set extra get parameters --> handle pretty url like '/category/product/'
					if (isset($route_data['pretty_parameters']) && 
						$route_data['pretty_parameters'] !== null) {
						self::setExtraGetParameters($route_data['pretty_parameters'], $path);
					}
					// Exit the loop
					break;

				}

			}

			$controller = $controllers_dir.$controller_name.self::$controllers_ext;

			// Default controller if none has been match
			// or if controller file not exists
			if (empty($controller_name) || !file_exists($controller)) {
				$controller = $controllers_dir.self::$default_controller;
			}

			// Require the controller
			require_once $controller;

		}

		/**
		 * Parse URI
		 * return array with path and optional get parameters
		 */
		private static function parseUriPath($uri) {

			// Get the base of the uri
			$basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
			// Remove base from uri string
			$uri = substr($uri, strlen($basepath));
			// Save optional get parameters
			if (strstr($uri, '?')){
				$uri_paramters = substr($uri, strpos($uri, '?')+1);
				// Remove parameters from uri
				$uri = substr($uri, 0, strpos($uri, '?'));
			} else {
				$uri_paramters = "";
			}
			// Clean the uri path (usefull for parseUriSegments)
			$uri_path = '/' . trim($uri, '/');

			return ['path' => $uri_path, 'parameters' => $uri_paramters];

		}

		/**
		 * Return an array with uri segments
		 */
		private static function parseUriSegments($uri) {
			
			$segments = explode('/', $uri);
			$clened_segments = [];

			// Clean up empty segments
			foreach ($segments as $segment) {
				if (trim($segment) != "") {
					$clened_segments[] = $segment;
				}
			}

			// Normalize path segment for home/landing page (http://yourwebsite.com/)
			if (count($clened_segments) === 0) {
				$clened_segments[0] = "/";
			}

			return $clened_segments;

		}

		/**
		 * Parse get parameters string and store in the $_GET array
		 */
		private static function setGetParameters($parameters_str){
			
			$parameters_arr = explode("&", $parameters_str);

			foreach ($parameters_arr as $parameter_str) {
				
				$parameter_arr = explode("=", $parameter_str);
	
				$_GET[$parameter_arr[0]] = isset($parameter_arr[1]) ? $parameter_arr[1] : "";

			}

		}

		/**
		 * Handle Pretty urls
		 * Parse segments of the uri path after the first
		 * and convert them in get parameters as define in the route
		 */
		private static function setExtraGetParameters($parameters_arr, $path_arr){

			// Remove first element from array
			array_shift($path_arr);

			// Count numbers of parameters
			$parameters_count = count($parameters_arr);
			$path_count = count($path_arr);

			// Loop and set $_GET parameters
			for($i = 0; $i < $parameters_count; $i++) {
				$_GET[$parameters_arr[$i]] = ($i<$path_count && !empty($path_arr[$i])) ? $path_arr[$i] : "";
			}

		}

	}

?>