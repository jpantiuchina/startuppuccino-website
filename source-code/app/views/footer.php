<?php
	
	/* General footer user included in all pages (except for landing page) */

?>

<script src="../app/assets/js/general.js"></script>

<?php if($userLogged){ ?>

	<?php // Ask for help form ?>
	<style>#askforhelp{position:fixed;z-index:99999;top:100%;left:0;width:100%;height:100%;background-color:rgba(20,20,20,0.9);color:#fff;transition:all 400ms;-webkit-transition:all 400ms;text-align:center}.close_dump{line-height:50px;color:#fff;font-size:32px;}</style>
	<div id="askforhelp">
		
		<div class="close close_dump" onclick="hideAskForHelp()">X</div>
		<form onsubmit="return askForHelp();">
			<input type="hidden" id="askforhelp_id" value="<?php echo $_SESSION['id'];?>" required />
			<label>Email</label>
			<input type="email" id="askforhelp_email" value="<?php echo $_SESSION['email'];?>" required />
			<br><br>
			<label>Message</label>
			<textarea id="askforhelp_message" required></textarea>
			<br><br>
			<input type="submit" name="submit" value="SEND">
		</form>

	</div>

	<script type="text/javascript">
		function showAskForHelp(){document.getElementById("askforhelp").setAttribute("style","top:0px");}
		function hideAskForHelp(){document.getElementById("askforhelp").removeAttribute("style");}
		function askForHelp(){
			var i = document.getElementById("askforhelp_id").value;
			var e = document.getElementById("askforhelp_email").value;
			var m = document.getElementById("askforhelp_message").value;
			if(i==""||e==""||m==""){alert("Please fill all inputs"+i+e+m);}
			else{connectGET("../app/controllers/askforhelp.php?i="+i+"&e="+e+"&m="+m,"askforhelp");}
			return false;
		}
		function askForHelpCallback(reponse){alert(response);}
	</script>

<?php } ?>