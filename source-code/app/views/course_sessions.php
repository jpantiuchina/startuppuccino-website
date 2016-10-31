<?php 

	define("DATE_FORMAT", "F jS Y");

	// Change the format of the date
	// return date without time
	function prettyDate($ugly_date){
		return date(DATE_FORMAT, strtotime($ugly_date));
	}

	function is_current($date){
		$format = "Y-m-d";
		$date = date($format, strtotime($date));
		if( $date >= date($format) && $date < date($format, strtotime(date($format) . ' + 6 days')) ){
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
					<p>Mentors coming</p>
					<?php foreach ($session['guests'] as $guest){ ?>
						<?php 
							if(!isset($guest['avatar']) || empty($guest['avatar'])){
								$guest['avatar'] = "avatar.svg";
							}
						?>
						<div class="guest" guest-id="<?php echo $guest['id']; ?>">
							<a href="../people/?user_id=<?php echo $guest['id']; ?>">
								<div style="background-image:url('../app/assets/pics/people/<?php echo $guest['avatar']; ?>')"></div>
							</a>
							<div class="guest__label">
								<span><?php echo $guest['firstname']." ".$guest['lastname']?></span>
							</div>
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

				<?php
					// Include the comment_system
					include '../app/controllers/course_sessions_comments.php';
				?>

			</div>

		</div>

	<?php } ?>

</section>