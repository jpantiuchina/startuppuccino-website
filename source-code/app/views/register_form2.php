<form action="" method="post" class="form_custom" onsubmit="return checkForm();">

	<?php if(isset($error_message) && $error_message != ""){ ?>

		<li class="form_box_item form_box_item--full">
			<p><?php print $error_message; ?></p>
		</li>

	<?php } ?>

	<div class="form_section_wrapper">

		<div class="form_section_slides">

			<section id="step0" class="form_section">

				<li class="form_box_item role_selection">
					<label class="student_role" onclick="switchRole(0)" id="role0">
						<input type="radio" name="role" value="student" onclick="switchInputs(0)" <?php if(isset($_POST['role']) && $_POST['role']=="student") print 'checked="checked"' ?> required/>I'm here to learn
					</label>
					<label class="mentor_role" onclick="switchRole(1)" id="role1">
						<input type="radio" name="role" value="mentor"  onclick="switchInputs(1)" <?php if(isset($_POST['role']) && $_POST['role']=="mentor") print 'checked="checked"' ?> required/>I'm here to help
					</label>
				</li>

				<li class="form_box_item form_box_item--full">
			        <p>Do you already have an Account? <a class="form_pretty_button_link" href="../login/">Login</a></p>
			    </li>

			</section>

			<section id="step1" class="form_section">
				
				<li class="form_box_item">
					<label>Email</label>
					<input class="form_pretty_general_input" type="email" name="email" placeholder="hello@startuppucino.com" <?php if(isset($_POST['email'])) print('value="'.$_POST['email'].'"'); ?> required/>
				</li>

				<br>

				<li class="form_box_item">
					<label>Password</label>
					<input class="form_pretty_general_input" type="password" id="password_input_1" name="password" <?php if(isset($_POST['password'])) print('value="'.$_POST['password'].'"'); ?> required/>
				</li>

				<li class="form_box_item">
					<label>Repeat Password</label>
					<input class="form_pretty_general_input"  id="password_input_2" type="password" name="password1" required/>
				</li>

			</section>


			<section id="step2" class="form_section">

				<li class="form_box_item">
					<label>Firstname</label>
					<input class="form_pretty_general_input" type="text" name="firstname" <?php if(isset($_POST['firstname'])) print('value="'.$_POST['firstname'].'"'); ?>required/>
				</li>

				<li class="form_box_item">
					<label>Lastname</label>
					<input class="form_pretty_general_input" type="text" name="lastname" <?php if(isset($_POST['lastname'])) print('value="'.$_POST['lastname'].'"'); ?> required/>
				</li>


				<li class="form_box_item">
					<label id="background_label">Faculty(Student)/Company(Mentor)</label>
					<input class="form_pretty_general_input" type="text" name="background" <?php if(isset($_POST['background'])) print('value="'.$_POST['background'].'"'); ?> required/>
				</li>

			</section>

			<section id="step3" class="form_section">
				
				<li class="form_box_item">
					<label>Skills (Separated by a comma - Minimum 1 skill)</label>
					<input class="form_pretty_general_input" type="text" name="skills" placeholder="e.g. IT, design, law, economics, management" <?php if(isset($_POST['skills'])) print('value="'.$_POST['skills'].'"'); ?> required/>
				</li>

				<li class="form_box_item">
					<input class="form_pretty_button_input" type="submit" value="Register" name="submit">
				</li>

			</section>

		</div>

	</div>

	<div class="form_section_index">
		<div onclick="prevStep()" id="prevStep" style="opacity:0">< back</div>
		<div><span id="index0" class="form_slide_index focus" onclick="changeSection('0')"></span></div>
		<div><span id="index1" class="form_slide_index" onclick="changeSection('1')"></span></div>
		<div><span id="index2" class="form_slide_index" onclick="changeSection('2')"></span></div>
		<div><span id="index3" class="form_slide_index" onclick="changeSection('3')"></span></div>
		<div onclick="nextStep()" id="nextStep">next ></div>
	</div>

</form>


<script type="text/javascript">

function switchRole(new_role){
	var style = "box-shadow:0px 0px 7px #000;-webkit-box-shadow:0px 0px 7px #000;";
	document.getElementById("role"+new_role).setAttribute("style",style);
	document.getElementById("role"+(1-parseInt(new_role))).removeAttribute("style");
	changeSection('1');
}

var CURRENT_STEP = 0;
function changeSection(step){	
	var wrapper = document.getElementsByClassName("form_section_slides")[0];
	var shift = (parseInt(step)*25) + "%";
	wrapper.setAttribute("style","transform:translateX(-"+shift+");-webkit-transform:translateX(-"+shift+");");
	updateIndex(step);
}
function updateIndex(step){
	step = parseInt(step);
	var indexes = document.getElementsByClassName("form_slide_index");
	var elem = document.getElementById("index"+step);
	if(elem != "undefined" && elem != null){
		for (var i = 0; i < indexes.length; i++) {
			indexes[i].className = "form_slide_index";
		}
		elem.className = "form_slide_index focus";
	}
	if(step==3){
		document.getElementById("nextStep").style = "opacity:0";
	} else {
		document.getElementById("nextStep").style = "opacity:1";
	}
	if(step==0){
		document.getElementById("prevStep").style = "opacity:0";
	} else {
		document.getElementById("prevStep").style = "opacity:1";
	}
	CURRENT_STEP = step;
}
function nextStep(){
	if(CURRENT_STEP>=3) return;
	CURRENT_STEP += 1;
	changeSection(CURRENT_STEP);
}
function prevStep(){
	if(CURRENT_STEP<=0) return;
	CURRENT_STEP -= 1;
	changeSection(CURRENT_STEP);
}

</script>
<script type="text/javascript" src="../app/assets/js/signup.js"></script>