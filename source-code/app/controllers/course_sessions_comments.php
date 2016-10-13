<?php 
	
	$comments_ = $session['comments'];

	include '../app/views/comments.php';

?>

<?php /*

<div class="comments">
					
					<div class="comments__wrapper">
						<?php if(isset() && count($session['comments'])>0 ){ ?>
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



*/

				?>