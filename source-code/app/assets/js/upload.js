
var upload_form_submit = function() {
    // Check if file input is empty
    if(document.getElementById("file_input").files.length == 0){
        alert("File input is empty!");
        return false;
    }
    
    // display loader
    Sp.layout.showLoading();
    
    // Return true to submit the form
    return true;
}

var notify_callback = function(text){
    alert(text);
    Sp.layout.hideLoading();
}

var render_picture_callback = function(filename,directory){
    document.getElementById("target_picture").setAttribute("src",directory+filename+"?"+(Math.floor((Math.random()*1000000)+1)));
    Sp.layout.hideLoading();
}