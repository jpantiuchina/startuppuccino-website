<section>

	<?php foreach ($sessions_set as $session) { ?>

		<div class="session" id="session<?php echo $session['id']; ?>">

			<div class="head">
				<h3><?php echo $session['title']." | ".$session['date']; ?></h3>
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
				<div class="comments_wrapper">

				</div>
			</div>

		</div>

	<?php } ?>

</section>