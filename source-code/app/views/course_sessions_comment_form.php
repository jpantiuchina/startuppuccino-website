<?php // Comment form -- Temporary using same style of askforhelp ?>
<div id="session_comments">
	
	<div class="center_column">
		<div class="center_aligner">
			
			<div class="background_close" onclick="hideCommentForm()"></div>

			<form class="session_comments_form" onsubmit="return commentSession();">
				<div class="ask_closer" onclick="hideCommentForm()">X</div>
				<input type="hidden" id="session_comments_s_id" value="<?php echo $_SESSION['id'];?>" required />
				<label>Comment</label>
				<textarea id="session_comments_c" required></textarea>
				<input type="submit" name="submit" value="SEND">
			</form>
		</div>
	</div>

</div>