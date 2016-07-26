<?php

	if($account){
	
?>

	<form action="" method="post" class="form_custom" >

		<li class="form_box_item">
			<label>Firstname</label>
			<input class="form_pretty_general_input" type="text" name="firstname" value="<?php echo trim($account['firstName']);?>" required/>
		</li>

		<li class="form_box_item">
			<label>Lastname</label>
			<input class="form_pretty_general_input" type="text" name="lastname" value="<?php echo trim($account['lastName']);?>" required/>
		</li>

		<li class="form_box_item">
			<label>Email</label>
			<input class="form_pretty_general_input" type="email" name="email" value="<?php echo trim($account['email']); ?>" required/>
		</li>

		<li class="form_box_item">
			<label>Faculty(Student)/Company(Mentor)</label>
			<input class="form_pretty_general_input" type="text" name="background" value="<?php echo trim($account['background']);?>" required/>
		</li>

		<li class="form_box_item">
			<label>Skills</label>
			<input class="form_pretty_general_input" type="text" name="skills" placeholder="e.g. IT, design, law, economics, management" value="<?php echo trim($account['skills']);?>" required/>
		</li>

		<br><br>

		<li class="form_box_item">
			<label>About me (optional)</label>
			<textarea class="form_pretty_general_input" name="about" placeholder="More info about me, about my startup idea, etc."><?php echo trim($account['about']);?></textarea>
		</li>

		<li class="form_box_item">
			<label>Socials Links</label>
			<input class="form_pretty_button_input" type="button" onclick="displaySocialBox()" value="Manage Socials" />
		</li>

		<!-- Temporary -->
		<input type="hidden" value="<?php echo $account['role'];?>" name="role">

		<!--

		<li class="form_box_item">
			<label>Role</label>
			<?php

			// If the user is an educator (a super user)
			// we do not need to show the possibility to change role.

			if ($account['role'] == "educator") {

				?>

					<label>
						<input type="radio" name="role" value="educator" checked="checked" required/>Educator (I am superman)
					</label>

				<?php

			} else {

				?>

					<label>
						<input type="radio" name="role" value="student" <?php if ($account['role'] == "student") print "checked=\"checked\"";?> required/>Student (I'm here to learn)
					</label>
					<label>
						<input type="radio" name="role" value="mentor" <?php if ($account['role'] == "mentor") print "checked=\"checked\"";?> required/>Mentor (I'm here to help)
					</label>
		
				<?php

			}

			?>
		</li>

			-->

		<li class="form_box_item">
			<input class="form_pretty_button_input" type="submit" name="update_account_info" value="SAVE" />
		</li>						
	</form>

	<hr>

	<form action="" method="post" class="form_custom" onsubmit="return checkForm();">

		<h4>Change Password</h4>
		
		<li class="form_box_item">
			<label>Old Password</label>
			<input class="form_pretty_general_input" type="password" name="old_password" id="password_input_1" required/>
		</li>

		<li class="form_box_item">
			<label>New Password</label>
			<input class="form_pretty_general_input" type="password" name="new_password" id="password_input_2" required/>
		</li>

		<li class="form_box_item">
			<input class="form_pretty_button_input" type="submit" name="update_password" value="SAVE" />
		</li>

	</form>


	<style> #social_box{position: fixed; width: 100%; left:0;top:100px;} #social_box_inside{width: 90%; margin:auto; max-width: 500px; min-width: 270px; background: #f9f9f9; border: 2px solid #777; padding: 15px;} </style>
	<div id="social_box" style="display:none">
		<div id="social_box_inside">
		<?php 

			// Socials array example:
			// [["facebook","https://facebook.com/user/helloworld","primary"],["twitter","https://twitter.com/user/helloworld","secondary"]]
			$socials = !empty($person["socials"]) ? json_decode(trim($person["socials"]),true) : array();
			$ind = 0;
			foreach ($socials as $social) {
				?>
					<li class="social" socialname="<?php echo $ind;?>" />
						<input type="text" value="<?php echo $social[0];?>" socialname="label" placeholde="Label (ex: Facebook, Google, ..)" />
						<input type="link" value="<?php echo $social[1];?>" socialname="link" placeholde="Url" />
						<label><input type="checkbox" socialname="priority" <?php if($social[2]=="primary"){echo "checked='checked'";}?> />Favorite</label>
					</li>
				<?php
				$ind++;
			}
			?>
				<div id="new_inputs_box"></div>
				<li class="form_box_item">
					<input class="form_pretty_button_input" type="button" onclick="renderNewSocialInput(<?php echo $ind; ?>,this)" value="New" />
				</li>
			

				<li class="form_box_item">
					<input class="form_pretty_button_input" type="button" onclick="saveSocialInputs()" value="SAVE" />
				</li>
			

			<?php

		?>

			<div style="padding-bottom:20px"><input class="form_pretty_button_input" style="float:right" type="button" onclick="hideSocialBox()" value="DONE" /></div>

		</div>

	</div>


	<script type="text/javascript">
		function checkForm(){
			// Add here some client checks to prevent bad ux
			// If you want to block -> return false;
			// If you want to proceed with post submitting -> return true;

			// Check if old and new password match
			if(document.getElementById('password_input_1').value != document.getElementById('password_input_2').value){
				return true;
			}
			else {
				alert("Old and new password are the same!");
				// reset new password input
				document.getElementById('password_input_2').value = "";
				return false;
			}
		}

		function displaySocialBox(){
			document.getElementById("social_box").style = "display:block";
		}

		function hideSocialBox(){
			document.getElementById("social_box").style = "display:none";	
		}

		function renderNewSocialInput(ind,elem){
			// Add new inputs set in the social_box for one more social
			node = document.createElement("li");
			node_label = document.createElement("input");
			node_link = document.createElement("input");
			node_priority = document.createElement("input");
			node_wrap_priority = document.createElement("label");
			node.setAttribute("class","social");
			node.setAttribute("socialname",ind);
			node_label.setAttribute("type","text");
			node_label.setAttribute("socialname","label");
			node_label.setAttribute("placeholder","Label (ex: Facebook, Google, ..)");
			node_link.setAttribute("type","link");
			node_link.setAttribute("socialname","link");
			node_link.setAttribute("placeholder","Url");
			node_priority.setAttribute("type","checkbox");
			node_priority.setAttribute("socialname","priority");

			node_wrap_priority.appendChild(node_priority);
			node_wrap_priority.appendChild(document.createTextNode("Favorite"));
			node.appendChild(node_label);
			node.appendChild(node_link);
			node.appendChild(node_wrap_priority);
			document.getElementById("new_inputs_box").appendChild(node);

			elem.setAttribute("onclick","renderNewSocialInput("+(ind+1)+",this)");
		}

		function saveSocialInputs(){
			// Collect all data and send them at server script "save_social_links.php"

			// Socials array example:
			// [["facebook","https://facebook.com/user/helloworld","primary"],["twitter","https://twitter.com/user/helloworld","secondary"]]

			socialdata = [];
			// Collect data
			inputs = document.getElementsByClassName("social");
			for (var i = 0; i <= inputs.length; i++) {
				if(inputs[i]){
					childs = inputs[i].childNodes;
					social = [];
					for (var k = childs.length - 1; k>= 0; k--) {
						if(childs[k].getAttribute("socialname") == "label"){
							social[0] = childs[k].value;
						} else if(childs[k].getAttribute("socialname") == "link") {
							social[1] = childs[k].value;
						} else if(childs[k].getAttribute("socialname") == "priority") {
							if(childs[k].checked){
								social[2] = "primary";
							} else {
								social[2] = "secondary";
							}
						}
					}
					socialdata.push(social);
				}
			};

			alert(socialdata);

			// Send data to server
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
			    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			        console.log(xmlhttp.responseText);
			        if(xmlhttp.responseText=="ok"){
			        	alert("Data saved");
			        	hideSocialBox();
			        } else {
			        	alert(xmlhttp.responseText);
			        }
			    }
			};
			xmlhttp.open("POST", "./social_link_controller.php", true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("socialdata="+socialdata);

		}
	</script>

	<!-- 
		TODO -> Add form to upload profile picture
		hint: use the iframe and with a javascript callback
			  in order to make the upload async
	-->

<?php

	} else {

		"No account selected.";

	}

?>