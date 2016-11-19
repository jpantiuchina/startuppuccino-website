
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

var render_picture_callback = function(filename, directory, bg){

    var picture = {
            dom : document.getElementById("target_picture"),
            path : directory+filename+"?"+(Math.floor((Math.random()*1000000)+1))
        }

    // Switch between img or div elements
    if (bg === true){
        picture.dom.setAttribute("style", "background-image:url('"+picture.path+"')");
    } else {
        picture.dom.setAttribute("src", picture.path);
    }

    Sp.layout.hideLoading();

}