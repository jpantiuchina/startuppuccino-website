"use strict";

function Startuppuccino(){

    // Global variable to store data for the search function
    var data_set = [];

    // Search filters keys
    var filer_keys = ["educator","mentor","student","guest","idea"];

    this.downloadSearchResult = function() {
        // Download data
        this.get({url : "../app/controllers/search.php"},function(data){
            data_set = Sp.helpers.shuffle(JSON.parse(data));
            Sp.search();
        });
    }

    this.search = function(text){

        if ( typeof text === "undefined" || text == null ){
            
            // Render all results
            this.layout.renderSearchResult(data_set);
            return;

        } else if ( filer_keys.indexOf(text) !== -1){
            
            // Render all results
            this.layout.renderSearchResult(data_set);
            // Use layout filters functions to filter results with css
            this.layout.filterSearch(text);
            return;
        
        }

        text = text.toLowerCase();

        var result_set = [],
            length = data_set.length,
            i;

        for (i = 0; i < length; i++) {
            var x = data_set[i];
            if( x.name.toLowerCase().search(text) != -1 ){
                result_set.push(x); 
            }
        }

        this.layout.renderSearchResult(result_set);

    }

    // Redirect to logout page
    this.logout = function() {
        window.location = "../logout/";
    }

    // http get request to server with callback
    this.get = function(data,callback){

        data.method = "get";

        this.http(data,callback);

    }

    // http post request to server with callback
    // content_type is and extra parameter to force the content type
    this.post = function(data,callback,content_type){
        
        // If content_type is define add info to data object
        if(typeof content_type !== "undefined"){
            data.type = content_type;
        }

        data.method = "post";

        this.http(data,callback);

    }

    this.http = function(data,callback){

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                // Debug: print result on console
                //console.log(xmlhttp.responseText);
                // Execute callback function
                callback(xmlhttp.responseText);
            }
        };
        xmlhttp.open(data.method, data.url, true);
        if(data.method === "post"){
            if(typeof data.type !== "undefined" && data.type === "json"){
                xmlhttp.setRequestHeader("Content-type", "application/json");
            } else if(typeof data.type !== "undefined" && data.type !== ""){
                xmlhttp.setRequestHeader("Content-type", data.type);
            } else {
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");        
            }
        }
        xmlhttp.send(data.parameters);
    
    }

}



Startuppuccino.prototype.helpers = {};

// helper to set multiple attributes on a node
Startuppuccino.prototype.helpers.setAttributes = function(element, attributes) {
    for(var key in attributes) {
        element.setAttribute(key, attributes[key]);
    }
}
// Smooth scroll
Startuppuccino.prototype.helpers.scrollTo = function(id, time, extra_offset) {
    if(typeof time === "undefined" || time == null){
        time = 400;
    }
    if(typeof extra_offset === "undefined" || extra_offset == null){
        extra_offset = 0;
    }
    var target = document.getElementById(id),
        to = target.offsetTop - extra_offset;
    this.animateScroll(document.body, "scrollTop", "", window.pageYOffset, to, time, true);
}
Startuppuccino.prototype.helpers.animateScroll = function(elem, style, unit, from, to, time, prop) {
    if( !elem) return;
    var start = new Date().getTime(),
        timer = setInterval(function() {
            var step = Math.min(1,(new Date().getTime()-start)/time);
            if (prop) {
                elem[style] = (from+step*(to-from))+unit;
            } else {
                elem.style[style] = (from+step*(to-from))+unit;
            }
            if( step == 1) clearInterval(timer);
        },25);
    elem.style[style] = from+unit;
}
Startuppuccino.prototype.helpers.shuffle = function(array){
  var currentIndex = array.length, temporaryValue, randomIndex;

  // While there remain elements to shuffle...
  while (0 !== currentIndex) {

    // Pick a remaining element...
    randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex -= 1;

    // And swap it with the current element.
    temporaryValue = array[currentIndex];
    array[currentIndex] = array[randomIndex];
    array[randomIndex] = temporaryValue;
  }

  return array;
}


Startuppuccino.prototype.layout = {};

// Loading screen
Startuppuccino.prototype.layout.showLoading = function(){
    document.getElementById("loading_screen").setAttribute("style","display:block");
}

Startuppuccino.prototype.layout.hideLoading = function(){
    document.getElementById("loading_screen").setAttribute("style","display:none");
}

// Helpers to easily hide or show sections
Startuppuccino.prototype.layout.showSection = function(target){
    var elem = document.getElementById(target);
    elem.classList.remove("hidden_element");
}
Startuppuccino.prototype.layout.hideSection = function(target){
    var elem = document.getElementById(target);
    elem.classList.add("hidden_element");
}

Startuppuccino.prototype.layout.toggleMobileMenu = function(){
    
    var menu_list = document.getElementById("menu_list"),
        is_visible = menu_list.getAttribute("data-mobile"),
        menu_button = document.getElementById("mobile_menu__button");

    if(is_visible === "0"){
        menu_list.className = "menu_list";
        menu_list.setAttribute("data-mobile","1");
        menu_button.className = "mobile_menu__button mobile_menu__button--close";
    } else {
        menu_list.className = "menu_list menu_list--hide";
        menu_list.setAttribute("data-mobile","0");
        menu_button.className = "mobile_menu__button";
    }

}

Startuppuccino.prototype.layout.toggleSearch = function() {
    var search = document.getElementById("search");
    search.classList.toggle("search--visible");
    if(search.classList.contains("search--visible")){
        document.getElementById("search_input").focus();
    }
}

// Render search results in the search section
Startuppuccino.prototype.layout.renderSearchResult = function(result_set) {
        
    var i,
        length = result_set.length,
        container = document.createElement("div"),
        wrapper = document.getElementById("search_result_list");

    var node = document.createElement("div"),
        a = document.createElement("a"),
        img = document.createElement("div"),
        inner_img = document.createElement("div"),
        labels = document.createElement("div"),
        p_name = document.createElement("p"),
        p_role = document.createElement("p");

    container.className = "search_results";
    node.className = "search_result";
    img.className = "search_result__pic";
    labels.className = "search_result__labels";
    p_name.className = "search_result__labels__name";
    p_role.className = "search_result__labels__role";

    labels.appendChild(p_name);
    labels.appendChild(p_role);
    img.appendChild(inner_img);
    a.appendChild(img);
    a.appendChild(labels);
    node.appendChild(a);

    for (i = 0; i < length; i++) {
        
        var x = result_set[i];
        
        var n = node.cloneNode(true);

        if(x.avatar.trim() === "people/"){
            x.avatar = "people/avatar.svg";
        }

        if(x.avatar.trim().substring(0,5) === "ideas"){
            n.className += " search_result--idea";
        } else {
            n.className += " search_result--" + x.role;            
        }
        n.children[0].href = "../" + x.id;
        n.children[0].children[0]
         .children[0].setAttribute("style","background-image:url('../app/assets/pics/" + x.avatar + "')");
        n.children[0].children[1].children[0].innerHTML = x.name;
        n.children[0].children[1].children[1].innerHTML = x.role;
        
        container.appendChild(n);
    }

    // Replace DOM with new results
    wrapper.innerHTML = "";
    wrapper.appendChild(container);

}

// Filert and hide (css) search results
Startuppuccino.prototype.layout.filterSearch = function(filter_key){

    var search_results = document.getElementsByClassName("search_result"),
        targets = document.getElementsByClassName("search_result--"+filter_key),
        hidden_class = "search_result--hidden";

    // Hide all results
    for (var i = 0, l = search_results.length; i < l; i++) {
        search_results[i].classList.add(hidden_class);
    }

    // Display filtered results
    for (var i = 0, l = targets.length; i < l; i++) {
        targets[i].classList.remove(hidden_class);
    }

}



/* Initialize Startuppuccino */

if(typeof Sp === "undefined" || Sp === null){ 

    var Sp = new Startuppuccino();

}


window.addEventListener("load", function(){  

    /* Add event listeners */
    var search_triggers = document.getElementsByClassName("search_trigger_button"),
        search_input = document.getElementById("search_input"),
        mobile_menu_button = document.getElementById("mobile_menu__button"),
        askforhelp_trigger_button = document.getElementById("askforhelp_trigger_button");

    var search_triggers_length = search_triggers.length;

    for (var i = 0; i < search_triggers_length; i++) {
        search_triggers[i].addEventListener("click", function(e){ Sp.layout.toggleSearch(); });
    }
    
    search_input.addEventListener("input", function(e){ 

        var input = e.target || e.srcElement,
            text = input.value;
        Sp.search(text);

    });
    
    //mobile_menu_button.addEventListener("click", function(e){ Sp.layout.toggleMobileMenu(e); });    
    
    //askforhelp_trigger_button.addEventListener("click", function(){ showAskForHelp(); });

    /* Download and store search data */
    Sp.downloadSearchResult();

}); 



/* ASK FOR HELP SECTION */

function showAskForHelp(){document.getElementById("askforhelp").setAttribute("style","top:0px");}
function hideAskForHelp(){document.getElementById("askforhelp").removeAttribute("style");}
function askForHelp(){
    var i = document.getElementById("askforhelp_id").value;
    var e = document.getElementById("askforhelp_email").value;
    var m = document.getElementById("askforhelp_message").value;
    if (i==""||e==""||m==""){alert("Please fill all inputs"+i+e+m);}
    else {Sp.get({url : "../app/controllers/askforhelp.php?i="+i+"&e="+e+"&m="+m}, function(response){alert(response);});}
    return false;
}