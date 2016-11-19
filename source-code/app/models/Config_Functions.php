<?php

class Config_Functions {

    function __construct() {
      require_once dirname( __DIR__ ) . '/controllers/session.php';
      $this->json_data = json_decode(file_get_contents( dirname( __DIR__ ) . "/configs/configs.json"), true);
    }
 
    function __destruct() {}

    /**
     * Load all configuration
     */
    public function load(){
      $this->loadIdeasConfigs();
    }
    
 
    /**
     * Load and save in the globas session variable the ideas configurations
     */
    private function loadIdeasConfigs(){

      $ideas_settings = $this->json_data["functionalities"]["ideas"];

      foreach ($ideas_settings as $key => $value) {
      
        $_SESSION["ideas_".$key] = $value;

      }

    }

    
    /**
     * Change specific configuration fields
     */
    private function setNewConfiguration($field_path, $field_value){

      // ...

    }




}

?>