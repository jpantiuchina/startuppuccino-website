function checkForm(){
	// Add here some client checks to prevent bad ux
	// If you want to block -> return false;
	// If you want to proceed with post submitting -> return true;

	// Check if password doublecheck match
	if(document.getElementById('password_input_1').value == document.getElementById('password_input_2').value){
		return true;
	}
	else {
		alert("Passwords do not match!");
		return false;
	}
}

function switchInputs(s){

	/*
	if(s===0){ // Student
		document.getElementById("background_label").innerHTML = "Faculty";
	} else if(s===1){ // Mentor
		document.getElementById("background_label").innerHTML = "Company";
	}
	*/

}