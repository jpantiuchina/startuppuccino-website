<?php

	/**
	 * Render Twig Template
	 * @author Marco Mondini http://mondspace.com
	 * 
	 * 
	 * @template_variables, @template_file are initialized in each view
	 *  
	 * @template_variables has a default value of []
	 * @template_dir has a default value "../templates/"
	*/
	class Twig_Loader
	{
		
		private static $template_variables = [];
		private static $template_dir;
		private static $twig;
		private static $load = false;
		private static $template = null;

		public static function setDir($template_dir){
			self::$template_dir = $template_dir;
			self::init();
		}

		public static function setVar($template_variables){
			self::$template_variables = $template_variables;
		}

		/**
		 * Load twig and set default options
		 */
		public static function load(){
			
			require_once dirname(__DIR__) . '/vendor/Twig/Autoloader.php';
			Twig_autoloader::register();
			
			self::$template_dir = dirname(__DIR__) . "/templates/";
			self::init();

			self::$load = true;

		}

		/**
		 * @template_variables, @template_dir are optional
		 * 
		 * Return the redered template
		 */
		public static function render($template_file, $template_variables = null){

			// Trigger load if not done yet
			if(self::$load == false){
				self::load();
			}

			if(empty($template_file)){
				return;
			}

			if(!empty($template_variables)){
				self::setVar($template_variables);
			}

			self::$template = self::$twig->render($template_file, self::$template_variables);	
		
		}

		/**
		 * Print rendered template
		 */
		public static function show($template_file = null, $template_variables = null){
			if(self::$template == null){
				self::render($template_file, $template_variables);
			}

			echo self::$template;
		}

		/**
		 * Instanziate twig with current options
		 */		
		private static function init(){
			$loader = new Twig_Loader_Filesystem(self::$template_dir);
			self::$twig = new Twig_Environment($loader);
		}
	}

?>