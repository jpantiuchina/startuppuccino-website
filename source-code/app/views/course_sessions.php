<?php 

	// Change the format of the date
	// return date without time
	function prettyDate($ugly_date){
		return date("d/m", strtotime($ugly_date));
	}

	function is_current($date){
		if( $date >= date("d/m") && $date < date("d/m", strtotime(date("Y-m-d") . ' + 6 days')) ){
			return true;
		} else {
			return false;
		}
	}

?>

<section class="sessions__wrapper">

	<?php foreach ($sessions_set as $session) { ?>

		<div class="session" id="session<?php echo $session['id']; ?>">

			<div class="session__contents">

				<?php 
					$head_class = "";
					// Check if is the current session
					if(is_current(prettyDate($session['date']))){
						$head_class = "head--current";
					}
				?>

				<div class="head <?php echo $head_class; ?>">
					<h3><?php echo $session['title']; ?></h3>
					<p>Lecture date: <?php echo prettyDate($session['date']); ?></p>
				</div>
				

				<div class="description">
					<p><pre><?php echo $session['description']; ?></pre></p>
				</div>


				<div class="guests" id="guests__<?php echo $session['id']; ?>">
					<?php if(isset($session['guests'])){ ?>
					<?php foreach ($session['guests'] as $guest){ ?>
						<div class="guest" guest-id="<?php echo $guest['id']; ?>">
							<a href="../people/?user_id=<?php echo $guest['id']; ?>">
								<div style="background-image:url('../app/assets/pics/people/<?php echo $guest['avatar']; ?>')"></div>
							</a>
						</div>
					<?php }} ?>
				</div>


				<div class="foot" data-session="<?php echo $session['id']; ?>">
					<span class="session_resources_button">Resources</span>
					<span class="session_comments_button">Comments</span>
				</div>


				<div class="resources">
					<?php $resources = json_decode($session['resource'], true); ?>
					<ul>
						<?php if (count($resources)>0) { ?>
							<?php foreach ($resources as $resource) { ?>
								<li>
									<a href="<?php echo $resource['link']; ?>" target="_blank">
										<span class="icon pdf"></span><?php echo $resource['name']; ?>
									</a>
								</li>
							<?php } ?>
						<?php } else { ?>
							<li>
								<a>
									<span class="icon pdf"></span>No resources for this lecture.
								</a>
							</li>
						<?php } ?>
					</ul>
				</div>


				<div class="comments">
					
					<div class="comments__wrapper">
						<?php if(isset($session['comments']) && count($session['comments'])>0 ){ ?>
						<?php foreach ($session['comments'] as $comment){ ?>
							<div class="comment" comment-id="<?php echo $comment['id']; ?>">
								
								<a class="comment__author" href="../people/?user_id=<?php echo $comment['author_id']; ?>">
									<?php $author_avatar = !empty($comment['author_avatar']) ? $comment['author_avatar'] : "people.png"; // Set the right avatar ?>
									<div style="background-image:url('../app/assets/pics/people/<?php echo $author_avatar; ?>')"></div>
								</a>
								<p class="comment__text"><?php echo $comment['text'] ?></p>

								<?php if($comment['author_id'] === $_SESSION['id']){ ?>
								<div class="comment__footer">
									<span class="comment__delete"
										  data-session="<?php echo $session['id']; ?>">delete</span>
								</div>
								<?php } ?>

							</div>
						<?php }} else { ?>
							<div class="comment">
								<a class="comment__author">
									<div style="background-image:url('../app/assets/pics/people/people.png');opacity:0.5"></div>
								</a>
								<p class="comment__text">No comments yet.</p>
							</div>
						<?php } ?>

						<div class="comments__editor">
							<textarea placeholder="Write a comment..."></textarea>
							<div>
								<input class="publish_comment_button" 
									   data-session="<?php echo $session['id']; ?>"
									   value="Publish"
									   type="button">
							</div>
							<div class="tiny_loader" style="display:none">
								<div></div><div></div>
							</div>
						</div>

					</div>
				
				</div>

			</div>

		</div>

	<?php } ?>

</section>