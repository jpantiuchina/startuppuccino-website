<?php
    
    // TODO: add check for already existing idea title = picture name

    require_once '../app/models/session.php';

    // Redirect to home if user is not logged
    if(!$userLogged){
        header("Location: ../");
        exit;
    }

    // Include and Initialize Upload and Account Functions
    require_once '../app/models/Upload_Functions.php';
    $upload_func = new Upload_Functions();
    require_once '../app/models/Ideas_Functions.php';
    $account_func = new Ideas_Functions($_SESSION["id"]);


    $dir = "../app/assets/pics/ideas/";
    
    // HELPERS FUNCTIONS

    // Function to return a js callback to parent window (the my_iframe in index.html)
    function set_notify($text){
        return "<script>parent.notify_callback('$text');</script>";
    }
    // Function to return a js callback to render the picture uploaded in the parent window
    function render_picture($filename,$dir){
        return "<script>parent.uploadIdeaPictureCallback('$filename','$dir');</script>";
    }
    // Function to rename a file with the hash of the user email
    function rename_profile_pic($filename){
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $basename = $_POST['title'];
        return md5($basename).".".$ext;
    }
    
    
    // VALIDATION CHECKS

    // Exit with an error if the file content is not set
    if(!isset($_FILES['picture']) || empty($_FILES['picture'])){
        exit(set_notify("No file selected. ".$_FILES['picture']["tmp_name"]));
    } else {
        $pic = $_FILES['picture'];
    }


    // Check file extensions
    $exts = ["jpg","jpeg","png","gif","JPG"];
    if(!in_array(pathinfo($pic["name"], PATHINFO_EXTENSION), $exts)){
        exit(set_notify("File extension not supported."));
    }

    // Check for errors
    if($pic["error"] > 0){
        // Collect errrors
        $errors = "Error: " . $_FILES["picture"]["error"];
        // Send email to notify for uploads errors
        mail("dev@startuppuccino.com","Upload errors",$errori); // Not active email
        exit(set_notify($errors));
    }
    

    // Check if $dir is a directory
    if(!is_dir($dir)){
        // Send error email to devs
        mail("dev@startuppuccino.com","Upload Error","$dir is not a directory.");
        exit(set_notify("We are sorry, at the moment the service is not available. Please try later."));
    }
    
    
    // STORING PICTURE

    // Rename file with the hash of the user email
    $pic["name"] = rename_profile_pic($pic["name"]);
    

    // Save the file
    $upload_func->setDir($dir);
    $upload_func->setFileName($pic["name"]);
    $upload_func->setTemporaryName($pic["tmp_name"]);
    $upload_func->setReplace(TRUE); // Set if the new file will replace the old one

    if($upload_func->upload()){
        exit(render_picture($pic["name"],$dir));
    }

    echo set_notify("Error while uploading..");

?>