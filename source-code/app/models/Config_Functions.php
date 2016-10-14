<?php

class Config_Functions {

    private $dev_local_host = "http://localhost/startuppuccino-website/source-code";
    private $thatsmy_name_host = "http://thatsmy.name/startuppuccino";

    function __construct() {
      require_once 'session.php';
      if($_SERVER['HTTP_HOST'] === "localhost"){
        $uri = $this->dev_local_host;
      } else if($_SERVER['HTTP_HOST'] === "thatsmy.name"){
        $uri = $this->thatsmy_name_host;
      } else {
        $uri = "http://".$_SERVER['HTTP_HOST'];
      }
      $this->json_data = json_decode(file_get_contents($uri."/app/configs/configs.json"),true); // After deploy path sould be set to abosolute
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