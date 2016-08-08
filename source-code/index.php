<?php 


require_once './app/models/session.php';

// Redirect to /home/ if user is logged
if($userLogged){
	header("Location: ./home/");
}

?>

<!DOCTYPE html>
<html>
	<head>
        
        <title>Startuppuccino</title>
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="icon" href="http://thatsmy.name/startuppuccino/land/icon.svg" type="image/svg+xml">
        <link rel="mask-icon" href="http://thatsmy.name/startuppuccino/land/icon.svg">
        
        <style type="text/css">
            @font-face{font-family:'Maison';src:url('maison/Maison-Mono-Regular.otf') format('opentype');}
            @font-face{font-family:'Maison';src:url('maison/Maison-Mono-Bold.otf') format('opentype');font-weight:bold}
            *{padding:0;margin:0;}
            body,html{height:100%;overflow:hidden;background-color:#000;}
            body{text-align:center;color:#513A2B;font-family:'Maison',Arial,sans-serif;}
            section{position:relative;height:33%;}
            #logo{max-height:100%;}
        	#tagline,#coomingsoon{display:block;margin:20px 50px;font-weight:900;}
        	#tagline_wrapper{position:absolute;bottom:0;width:100%;}
        	#coomingsoon{color:#7FB03B;}
        	#tagline{color:#BE3B43;}
        	.toplink{margin:2px;}
        	.toplink>a{display:inline-block;padding:15px;color:#513A2B;text-decoration:none;font-weight:bold}
        	.toplink>a:hover{color:#fff;transition:all 200ms;-webkit-transition:all 200ms;}
        	.c0{fill:#000;}
        	.c3{fill:#513A2B;}
        	.c1{fill:#7FB03B;}
        	.c2{fill:#BE3B43;}
        	.t_long{transition:1000ms all;-webkit-transition:1000ms all;}
        	.fadeOut{opacity:0;}
        	.fadeIn{opacity:1;}
        </style>
        
        <script>
            var T_LONG = 1000, T_SHORT = 40;
            var tagline = "Active learning experience for your next startup";
            var coomingsoon = "Cooming soon...";
            function init(){
                displayLogo();
                setTimeout(function(){displayText()},T_LONG);
                setTimeout(function(){displayLogoIcon();},(tagline.length+coomingsoon.length)*T_SHORT);
            }

            function displayLogoIcon(){
            	document.getElementById("c1").setAttribute("class","c1 t_long");
            	setTimeout(function(){document.getElementById("c2").setAttribute("class","c2 t_long");},T_SHORT*10);
            	setTimeout(function(){document.getElementById("c3").setAttribute("class","c3 t_long");},T_SHORT*20);
            }
            
            function displayLogo(){
                document.getElementById("logo").setAttribute("class","fadeIn t_long");
            }
            
            function displayText(){
                displayTagline();
                setTimeout(function(){displayCS()},tagline.length*T_SHORT);
            }
            
            function displayTagline(){
                return textLoop(tagline,0,"tagline");
            }
            
            function displayCS(){
                textLoop(coomingsoon,0,"coomingsoon");
            }
            
            function textLoop(s,i,id){
                if(i >= s.length){
                    return ;
                } else {
                    document.getElementById(id).appendChild(document.createTextNode(s.charAt(i)));
                    i=i+1;
                    setTimeout(function(){textLoop(s,i,id);},T_SHORT);
                }
            }
        </script>
        
    </head>
    <body onload="init()">
        
        <section>
        	<span class="toplink"><a href="./login/">Login</a></span>
        	<span class="toplink"><a href="./signup/">Register</a></span>
        	<span class="toplink"><a href="./about/">About</a></span>
        	<p id="tagline_wrapper">
                <span id="tagline"></span>
            </p>
        </section>

        <section>
            <svg id="logo" class="fadeOut t_long" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1359.1 415.9" style="enable-background:new 0 0 1359.1 415.9;" xml:space="preserve">
                <g>
                	<path class="c3" d="M350.3,208c0.4,3.2,0.8,5.1,2.2,8.3c2.1,4.1,5.8,7.5,13.6,7.5c7.2,0,12.7-3.2,12.7-9.6c0-5.5-3.7-8.5-13.3-11
                		c-7.5-2-12.3-3.7-17-7c-4.7-3.3-7.1-8.2-7.1-14.8c0-5.5,2.1-10.2,6.4-14.2c4.3-4,10.2-5.9,17.7-5.9c12.6,0,22.7,7.1,25.7,20.1
                		l-13,2.8c-1.4-5-5.5-9.4-12.7-9.4c-6.1,0-10,2.9-10,6.6c0,4.1,4.4,5.8,14,8.7c7,2.2,11.9,4.3,14.6,6.1c5.9,4.1,8.8,10,8.8,17.9
                		c0,6.9-2.4,12.5-7.3,16.8c-4.9,4.3-11.3,6.4-19.5,6.4c-8.6,0-15.4-2.6-19.5-6c-6.5-5.8-8.6-13.8-9.4-20.9L350.3,208z"></path>
                	<path class="c3" d="M416.5,193.7h-10.2v-13h10.2V163H430v17.7h22.7v13H430V220c-0.1,1.2,0.4,4.1,4.8,4.4c4.2,0,6-1.8,7-9l12.7,2.1
                		c-2.4,14.9-9.3,19.9-19.7,19.9c-5.3,0-9.7-1.5-13.1-4.5c-3.4-3-5.2-7-5.2-11.9V193.7z"></path>
                	<path class="c3" d="M469.2,197.3c0.5-5.7,3-10.1,7.3-13.3c4.4-3.2,9.3-4.9,14.7-4.9c5.9,0,10.9,1.7,15.2,5c4.3,3.3,6.5,7.7,6.5,13
                		v25c0,1.6,1,2.3,3.1,2.3l2-0.3l2.2,10.9c-2.7,1.6-5.5,2.4-8.3,2.4c-3.2,0-6.7-1.6-8-2.8l-1-0.9c-3.4,2.5-7.9,3.7-13.2,3.7
                		c-12.9,0-21.3-6.9-21.3-17.8c0-11.1,7.4-15.3,22.3-17.4c5.9-0.8,8.8-1.9,8.8-4.8c0-3.5-2.5-5.3-7.5-5.3c-5.8,0-9.2,1.6-10,7.3
                		L469.2,197.3z M499.3,210.4l-0.2,0.2c-0.3,0.3-1.9,1.3-6,1.9c-3.7,0.5-5.4,0.8-7.9,1.8c-2.4,0.9-3.4,2.5-3.4,4.9
                		c0,3.4,2.9,5.2,8.8,5.2c0.9,0,2-0.1,3.1-0.3c2.4-0.4,5.6-2.4,5.6-5.4V210.4z"></path>
                	<path class="c3" d="M533.6,235.8v-13h13.6v-29.1h-12.4v-13h25.5v2.7c0.1-0.1,3.4-4.3,9-4.3c4.3,0,8,1.8,11.2,5.3
                		c3.3,3.5,5.1,8.7,5.3,15.7l-13.1,2.1c-0.6-6.8-3-10.1-7.1-10.1c-3.6,0-4.9,2.1-4.9,3.7v27h19.7v13H533.6z"></path>
                	<path class="c3" d="M610.1,193.7h-10.2v-13h10.2V163h13.5v17.7h22.7v13h-22.7V220c-0.1,1.2,0.4,4.1,4.8,4.4c4.2,0,6-1.8,7-9
                		l12.7,2.1c-2.4,14.9-9.3,19.9-19.7,19.9c-5.3,0-9.7-1.5-13.1-4.5c-3.4-3-5.2-7-5.2-11.9V193.7z"></path>
                	<path class="c3" d="M662.9,180.7h13.5v33.8c0,5.9,3.6,9.9,10.2,9.9c6.6,0,10.1-3.5,10.1-9v-34.8h13.5v55.2h-13.1v-2.7
                		c-3.5,2.8-7.6,4.3-12.1,4.3c-6.3,0-11.7-2.2-15.9-6.6c-4.2-4.5-6.2-10-6.2-16.8V180.7z"></path>
                	<path class="c3" d="M726.5,259.3v-78.6h13.1v2.7c0.3-0.3,0.8-0.7,1.6-1.1c0.7-0.5,2.2-1.1,4.4-1.9c2.3-0.8,4.6-1.2,6.9-1.2
                		c7.4,0,13.3,2.6,17.8,7.7c4.5,5.1,6.7,12.2,6.7,21.4c0,9.3-2.2,16.4-6.7,21.5c-4.5,5.1-10.4,7.6-17.8,7.6c-4.9,0-9.4-1.4-11-2.6
                		L740,234v25.3H726.5z M740,213.9c0,6.2,4.7,10.5,11.9,10.5c7.8,0,11.5-4.9,11.5-16.1c0-11.2-3.6-16.1-11.5-16.1
                		c-7.2,0-11.9,4.3-11.9,10.4V213.9z"></path>
                	<path class="c3" d="M791,259.3v-78.6h13.1v2.7c0.3-0.3,0.8-0.7,1.6-1.1c0.7-0.5,2.2-1.1,4.4-1.9c2.3-0.8,4.6-1.2,6.9-1.2
                		c7.4,0,13.3,2.6,17.8,7.7c4.5,5.1,6.7,12.2,6.7,21.4c0,9.3-2.2,16.4-6.7,21.5c-4.5,5.1-10.4,7.6-17.8,7.6c-4.9,0-9.4-1.4-11-2.6
                		l-1.4-0.8v25.3H791z M804.6,213.9c0,6.2,4.7,10.5,11.9,10.5c7.8,0,11.5-4.9,11.5-16.1c0-11.2-3.6-16.1-11.5-16.1
                		c-7.2,0-11.9,4.3-11.9,10.4V213.9z"></path>
                	<path class="c3" d="M854.5,180.7h13.5v33.8c0,5.9,3.6,9.9,10.2,9.9c6.6,0,10.1-3.5,10.1-9v-34.8h13.5v55.2h-13.1v-2.7
                		c-3.5,2.8-7.6,4.3-12.1,4.3c-6.3,0-11.7-2.2-15.9-6.6c-4.2-4.5-6.2-10-6.2-16.8V180.7z"></path>
                	<path class="c3" d="M962.6,217c-0.7,6-3.1,10.9-7.4,14.8c-4.3,3.7-9.5,5.6-15.8,5.6c-14.7,0-24.3-10.7-24.3-29.1
                		c0-18.4,9.6-29.1,24.3-29.1c6.4,0,11.6,1.9,15.8,5.7c4.3,3.7,6.7,8.6,7.4,14.7l-12.9,2.1c-0.9-6.4-4.3-9.5-10.2-9.5
                		c-7.6,0-10.8,4.8-10.8,16.1c0,11.3,3.2,16.1,10.7,16.1c5.9,0,9.4-3.1,10.3-9.5L962.6,217z"></path>
                	<path class="c3" d="M1023.2,217c-0.7,6-3.1,10.9-7.4,14.8c-4.3,3.7-9.5,5.6-15.8,5.6c-14.7,0-24.3-10.7-24.3-29.1
                		c0-18.4,9.6-29.1,24.3-29.1c6.4,0,11.6,1.9,15.8,5.7c4.3,3.7,6.7,8.6,7.4,14.7l-12.9,2.1c-0.9-6.4-4.3-9.5-10.2-9.5
                		c-7.6,0-10.8,4.8-10.8,16.1c0,11.3,3.2,16.1,10.7,16.1c5.9,0,9.4-3.1,10.3-9.5L1023.2,217z"></path>
                	<path class="c3" d="M1035.8,235.8v-13h19.3v-29.1h-17v-13h30.5v42.2h16.4v13H1035.8z M1055.1,175.8V163h13.5v12.8H1055.1z"></path>
                	<path class="c3" d="M1100.7,235.8v-55.2h13.1v2.7c3.2-2.8,7.1-4.3,11.6-4.3c6.4,0,11.6,2.2,15.6,6.7c4.1,4.4,6,9.9,6,16.7v33.4
                		h-13.5V202c0-5.9-3.1-9.9-9.7-9.9c-6.4,0-9.6,3.4-9.6,9v34.8H1100.7z"></path>
                	<path class="c3" d="M1185.1,237.4c-7.4,0-13.2-2.5-17.7-7.6c-4.4-5.1-6.6-12.3-6.6-21.5c0-9.3,2.2-16.3,6.6-21.4
                		c4.5-5.1,10.3-7.7,17.7-7.7s13.2,2.6,17.6,7.7c4.5,5.1,6.7,12.2,6.7,21.4c0,9.3-2.2,16.4-6.7,21.5
                		C1198.3,234.9,1192.5,237.4,1185.1,237.4z M1185.1,224.4c3.7,0,6.5-1.2,8.1-3.7c1.8-2.6,2.6-6.7,2.6-12.4c0-5.7-0.8-9.8-2.6-12.3
                		c-1.7-2.6-4.4-3.9-8.1-3.9s-6.5,1.2-8.2,3.9c-1.7,2.5-2.5,6.6-2.5,12.3c0,5.7,0.8,9.8,2.5,12.4
                		C1178.6,223.1,1181.3,224.4,1185.1,224.4z"></path>
                </g>
                <circle id="c1" class="c0" cx="131.1" cy="209" r="21.3"></circle>
                <circle id="c2" class="c0" cx="187.8" cy="148.8" r="35.4"></circle>
                <circle id="c3" class="c0" cx="248.3" cy="268.9" r="56.7"></circle>
            </svg>
        </section>
        
        <section>
            <p>
                <span id="coomingsoon"></span>
            </p>
        </section>

	</body>
</html>