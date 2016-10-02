<!--
<div id="askforhelp_button" onclick='showAskForHelp()'>
	<div></div>
</div> -->

<?php // Ask for help form ?>
<div id="askforhelp">
	
	<div class="center_column">
		<div class="center_aligner">
			
			<div class="background_close" onclick="hideAskForHelp()"></div>

			<form class="askforhelp_form" onsubmit="return askForHelp();">
				<div class="ask_closer" onclick="hideAskForHelp()">x</div>
				<input type="hidden" id="askforhelp_id" value="<?php echo $_SESSION['id'];?>" required />
				<label>Email</label>
				<input type="email" id="askforhelp_email" value="<?php echo $_SESSION['email'];?>" required />
				<label>Message</label>
				<textarea id="askforhelp_message" required></textarea>
				<input type="submit" name="submit" value="SEND">
			</form>
		</div>
	</div>

</div>