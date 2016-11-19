<?php

	/**
	 * Render Twig Template
	 * 
	 * @template_variables, @template_file are initialized in each view
	 *  
	 * @template_variables has a default value of []
	 * @template_dir has a default value "../templates/"
	*/
	class Twig_Loader
	{
		
		private $template_dir;
		private $template_variables;
		private $twig;

		function __construct($template_dir = null){
			
			require_once dirname(__DIR__) . '/vendor/Twig/Autoloader.php';
			Twig_autoloader::register();

			$this->template_dir = dirname(__DIR__) . "/templates/";
			$this->template_variables = [];

			$this->init();

		}

		private function init(){
			$loader = new Twig_Loader_Filesystem($this->template_dir);
			$this->twig = new Twig_Environment($loader);
		}

		public function setDir($template_dir){
			$this->template_dir = $template_dir;
			$this->init();
		}

		public function setVar($template_variables){
			$this->template_variables = $template_variables;
		}

		/**
		 * @template_variables, @template_dir are optional
		 * 
		 * Return the redered template
		 */
		public function render($template_file, $template_variables = null){

			if(empty($template_file)){
				return;
			}

			if(!empty($template_variables)){
				$this->setVar($template_variables);
			}

			// By default add $_SESSION data
			$this->template_variables['sess'] = $_SESSION;

			return $this->twig->render($template_file, $this->template_variables);	
		
		}
	}

?>