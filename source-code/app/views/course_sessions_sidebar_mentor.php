
<section class="column_right">

	<div class="sidebar_container">

		<div class="head">
			<span>Lecture's attendance</span>
		</div>

		<div class="main">

			<?php foreach($sessions_set as $session){ ?>
				<div class="list_el">
			 		<div class="list_el__left">
				 		<p><?php echo $session['title']; ?></p>
				 		<p><?php echo $session['date']; ?></p>
					</div>
					<div class="list_el__right">
						<span 
							class="checked c_green" 
							onclick="SpHome.mentors.setAvailability(<?php echo $session['id']; ?>,this)" 
							<?php if ( in_array($session['id'], $_SESSION['lectures_availability']) ){ ?>
								data-action="remove">YES</span>
							<?php } else { ?>
								data-action="add">NO</span>
							<?php } ?>
					</div>
				</div>
			<?php } ?>

		</div>

	</div>

</section>