function upload_form_submit() {
    // Check if file input is empty
    if(document.getElementById("file_input").files.length == 0){
        alert("File input is empty!");
        return false;
    }
    
    // display loader
    showLoadingScreen();
    
    // Return true to submit the form
    return true;
}

function notify_callback(text){
    alert(text);
    hideLoadingScreen();
}

function render_picture_callback(filename){
    document.getElementById("target_picture").setAttribute("src","../app/assets/pics/people/"+filename+"?"+(Math.floor((Math.random()*1000000)+1)));
    hideLoadingScreen();
}