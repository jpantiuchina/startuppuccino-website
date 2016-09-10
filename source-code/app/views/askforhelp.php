
<div id="askforhelp_button" onclick='showAskForHelp()'>
	<div><!-- ask.svg icon --></div>
</div>

<?php // Ask for help form ?>
<div id="askforhelp">
	
	<div class="tempclose" onclick="hideAskForHelp()">X</div>

	<div class="center_column">
		<div class="center_aligner">
			<form class="askforhelp_form" onsubmit="return askForHelp();">
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