
<section class="column_right">

	<div class="sidebar_container">

		<div class="head">
			<span>Lecture's attendance</span>
		</div>

		<div class="main">

			<?php foreach($sessions_set as $session){ ?>
				<?php
					$checkbox = ""; 
					$pitch_ = 0;
					if ( in_array($session['id'], $_SESSION['lectures_availability']) ){
						$data_action = "remove";
						$pitch_ = 1;//$_SESSION['lectures_availability'][$session['id']]; // 0 or 1
						$checkbox = "checked";
					} else {
						$data_action = "add";
					}
				?>

				<div class="list_el">
			 		<div class="list_el__left">
			 			<a href="#session<?php echo $session['id']; ?>">
					 		<p><?php echo $session['title']; ?></p>
					 		<p><?php echo $session['date']; ?></p>
					 	</a>
					</div>
					<div class="list_el__right">
						<div class="button_availability action_<?php echo $data_action; ?>"
							 data-action="<?php echo $data_action; ?>">
							<span 
								<?php if($data_action === "add") { ?>
								onclick="SpHome.mentors.setAvailability(<?php echo $session['id']; ?>,this)"
								<?php } ?>>YES</span><!--
							--><span 
								<?php if($data_action === "remove") { ?>
								onclick="SpHome.mentors.setAvailability(<?php echo $session['id']; ?>,this)"
								<?php } ?>>NO</span>
						</div>
						<div class="button_pitch">
							<label class="<?php echo $checkbox; ?>">
								<div class="button_pitch_click"
									 onclick="SpHome.mentors.setPitch(<?php echo $pitch_; ?>)"></div>
								<span>PITCH</span><!--
								--><input type="checkbox" 
										  <?php echo ($checkbox === "checked") ? 'checked=""' : ''; ?>" />
							</label>
						</div>
						<div class="tiny_loader" style="display:none">
							<div></div><div></div>
						</div>
					</div>
				</div>
			<?php } ?>

		</div>

	</div>

</section>