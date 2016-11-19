<?php
 
class Upload_Functions {

    var $dir;
    var $name;
    var $path;
    var $temp_name;
    var $replace = false;

    function __construct() {}
 
    function __destruct() {}

    /**
     * Update new file path
     */
    private function updatePath(){
        $this->path = $this->dir . $this->name;
    }

    /**
     * Set the upload directory
     */
    public function setDir($dir_){
        $this->dir = $dir_;
        $this->updatePath();
    }

    /**
     * Set the file name
     */
    public function setFileName($name_){
        $this->name = $name_;
        $this->updatePath();
    }

    /**
     * Set the upload directory
     */
    public function setTemporaryName($name_){
        $this->temp_name = $name_;
    }

    /**
     * Set the upload directory
     */
    public function setReplace($bool_){
        $this->replace = $bool_;
    }

    /**
     * Automatically rename the file in order not to replace the existing one
     */
    private function rename(){
        // Define the new name
        // ... [NOT YET IMPLEMENTED] ...
        $new_name = $this->name;
        // Set the renamed file name
        $this->setFileName($name_);
    }

    /**
     * Filename exists
     */
    private function filename_exists($file_){
        foreach (scandir($this->dir) as $file) {
            if($this->file_basename($file) == $this->file_basename($file_)) return true;
        }
        return false;
    }
    

    /**
     * Delete file based on file basename
     */
    private function delete_file($file_){
        foreach (scandir($this->dir) as $file) {
            if($this->file_basename($file) == $this->file_basename($file_)){
                unlink($this->dir.$file);
            }
        }
    }


    /**
     * Get file basename (without extension)
     */
    private function file_basename($file){
        return basename($file, pathinfo($file, PATHINFO_EXTENSION));
    }


    /**
     * Upload
     */
    public function upload(){
        
        // Check if a file with same name already exists
        if($this->filename_exists($this->name)){
            if($this->replace){
                // Remove existing file
                $this->delete_file($this->name);
            } else {
                // Rename the new file name
                $this->rename();
            }
        }

        // Store the uploaded file
        return move_uploaded_file($this->temp_name, $this->path);
    
    }

}

?>