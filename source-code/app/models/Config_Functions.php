<?php
 
class Config_Functions {

    var $json_data;

    function __construct() {
      require_once 'session.php';
      $this->json_data = json_decode(file_get_contents("../app/models/configs/configs.json"),true); // After deploy path sould be set to abosolute
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
        
        echo $key.$value;

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