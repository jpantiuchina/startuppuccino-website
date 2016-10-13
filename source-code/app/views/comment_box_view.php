<div class="comment_box">

	<div class="center_column">
		<div class="center_aligner">

		<div class="background_close" onclick="SpIdea.hideCommentBox()"></div>

			<div class="comment_box__content">

				<div class="_closer" onclick="SpIdea.hideCommentBox()">x</div>

				<div class="comment_box__editor">
					<form action="" method="post" id="comment_box_form" onsubmit="return SpIdea.submitComment()">
						<textarea id="comment_textarea" placeholder="Write here your comment..."></textarea>
						<input type="submit" value="publish" />
					</form>
				</div>

				<div class="comment_box__list" id="comments">
					Loading comments...
				</div>
			</div>

		</div>
	</div>

</div>