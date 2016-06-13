// !Only for test
// Project data matrix example
/*
	
	0 -> null
	1 -> happy
	2 -> sad
	3 -> ...
	7 -> end

*/
smiles = ["null","happy","sad","...","...","...","...","end"];
initial_project_data = [

	[1,2,1,0,0,0],
	[0,1,1,2,1,0],
	[0,0,0,1,0,0]

]

// !Only for test
// Array with all current milestones
milestones_array = [
	"Milestone 1",
	"Milestone 2",
	"Milestone 3",
	"Milestone 4",
	"Milestone 5",
	"Milestone 6"
]

function Project_Console(project){

	this.project = project;
	const P_CONSOLE = document.getElementById('project_console');
	const P_CHART = document.getElementById('project_chart');

	// Display the project console
	this.show = function(){
		P_CONSOLE.style.display = 'block';
		P_CHART.style.display = 'none';
	}

	// Hide the project console
	this.hide = function(){
		P_CONSOLE.style.display = 'none';
		P_CHART.style.display = 'block';
	}

	// Toggle project console contents
	// Show the specified section
	this.toggle = function(t) {
		// Hide all the sections
		elems = document.getElementsByClassName('project_console__section');
		for (var i = elems.length - 1; i >= 0; i--) {
			elems[i].classList.add('project_console__section--hidden');	
		}
		// Show the section
		section_x = document.getElementById(t);
		section_x.classList.remove('project_console__section--hidden');
	}

	// Display the project console with the elements to define a new pivot
	this.pivot = function() {
		// Add correct data to the console
		// Create array with only reached milestones
		node = document.createElement("SELECT");
		node.setAttribute("id","pivot_milestone");
		current_milestone_id = this.project.getCurrentMilestoneID();
		for (var i = current_milestone_id; i >= 0; i--) {
			node.appendChild(pivotMilestoneDOMelem(milestones_array[i],i));
		}
		// Append data to DOM
		document.getElementById('project_console__pivot__milestones').innerHTML = ""; // Clear old data
		document.getElementById('project_console__pivot__milestones').appendChild(node); // Add new data
		// Toggle the project console view
		this.toggle('project_console__pivot');
		// Display the project console
		this.show();
	};

	// Create a milestone option for the pivot select
	function pivotMilestoneDOMelem(milestone_name,milestone_id){
		// create the node
		option = document.createElement("OPTION");
		// Set all the attributes
		option.setAttribute("value",milestone_id);
		// append child text node
		option.appendChild(document.createTextNode(milestone_name));
		return option;
	}

	// Display the project console with the elements to define a new milestone
	this.milestone = function() {
		// Add correct data to the console
		// Get new milestone name
		milestone_id = this.project.getCurrentMilestoneID() + 1;
		milestone_name = milestones_array[milestone_id];
		// Update milestone title
		document.getElementById("project_console__milestone__title").innerHTML = milestone_name;
		// Add milestone requirements to the console
		// ... not for the mockup
		// Toggle the project console view
		this.toggle('project_console__milestone');
		// Display the project console
		this.show();
	};

	// Submit new milestones
	// Inputs validation here
	this.submitMilestone = function() {
		// Inputs validation
		// ...
		// Get the current mood
		current_mood = document.getElementById("current_mood").value;
		// Render the new milestone
		if(this.project.renderNewMilestone(current_mood)){
			// Chart updated
			// Close the console
			this.hide();
		}
	}

	// Submit new pivot
	this.submitPivot = function() {
		// Inputs validation
		// ...
		// Get the new milestone to pivot
		pivot_milestone = document.getElementById("pivot_milestone").value;
		// Render the new pivot
		if(this.project.renderNewPivot(pivot_milestone)){
			// Chart updated
			// Close the console
			this.hide();
		}
	}

}


// The main class
function Project(pivots,data){

	this.pivots = pivots;
	this.data = data;

	this.renderNewPivot = function(pivot_milestone) {
		
		// TODO manage special case, i.g. only one milestone per row

		// Remove active class and next milestone from current active row
		current_row = document.getElementsByClassName("project_chart__row--active")[0];
		current_row.classList.remove("project_chart__row--active");
		current_active_milestone = document.getElementsByClassName("milestone--active")[0];
		current_active_milestone.classList.remove("milestone--active");
		current_active_milestone_segment = current_active_milestone.childNodes[3];
		current_active_milestone_segment.classList.remove("project_chart__segment--halfright");
		current_next_milestone = document.getElementsByClassName("milestone--next")[0];
		current_next_milestone.classList.remove("milestone--next");
		current_next_milestone_smile = current_next_milestone.childNodes[1];
		current_next_milestone_smile.removeAttribute("onclick");
		current_next_milestone_smile.classList.remove("milestone__smile--target");
		current_next_milestone_smile.classList.add("milestone__smile--placeholder");

		// Manange special conditions
		if(countCurrentRowMilestones() != 1){
			current_active_milestone_segment.classList.add("project_chart__segment--half");
		} else {
			// Only one milestone in this row
			current_active_milestone_segment.classList.add("project_chart__segment--placeholder");
		}

		// Get the current mood
		current_mood = document.getElementById("current_mood_pivot").value;

		// Create a new row to insert in the chart
		row = document.createElement("DIV");
		row.classList.add("project_chart__row");
		row.classList.add("project_chart__row--active");

		// Milestones wrapper
		milestones_wrapper = document.createElement("DIV");
		milestones_wrapper.classList.add("project_chart__milestones"); 

		// Create each milestone DOM and append to row
		for(var i=0; i<milestones_array.length; i++){

			// Check if is the pivot milestone
			if(i == pivot_milestone){
				// Create active milestone
				milestone_node = newActiveMilestone(current_mood);
			} else if ((i-1) == pivot_milestone){
				// Create target milestone (--next)
				milestone_node = newTargetMilestone();
			} else {
				// Create placeholder milestone 
				milestone_node = newPlaceholderMilestone();
			}

			// TODO --> manage first and last milestone

			milestones_wrapper.appendChild(milestone_node);
			milestones_wrapper.appendChild(document.createTextNode("")); // fix
			
		}

		row.appendChild(milestones_wrapper);

		// Insert the row after the --last row
		document.getElementsByClassName("project_chart__contents")[0].insertBefore(row, current_row);

		// Update project_data array
		new_data_row = [];
		for (var i = 0; i < milestones_array.length; i++) {
			if(i == pivot_milestone){
				new_data_row[new_data_row.length] = parseInt(current_mood);
			}else{
				new_data_row[new_data_row.length] = 0;
			}
		}
		data[data.length] = new_data_row;

		return true;
	}

	function countCurrentRowMilestones(){
		row = data[data.length-1];
		var k = 0;
		for(var i=0; i<row.length; i++){
			if(row[i]!=0) k++;
		}
		return k;
	}

	function newActiveMilestone(mood){
		node = document.createElement("DIV");
		node.classList.add("milestone");
		node.classList.add("milestone--active");
		smile = document.createElement("DIV");
		smile.classList.add("milestone__smile");
		smile.classList.add("milestone__smile--"+smiles[mood]);
		segment = document.createElement("DIV");
		segment.classList.add("project_chart__segment");
		segment.classList.add("project_chart__segment--halfright");
		node.appendChild(document.createTextNode("")); // fix
		node.appendChild(smile);
		node.appendChild(document.createTextNode("")); // fix
		node.appendChild(segment);
		return node;
	}

	function newTargetMilestone(){
		node = document.createElement("DIV");
		node.classList.add("milestone");
		node.classList.add("milestone--next");
		node.classList.add("milestone--placeholder");
		smile = document.createElement("DIV");
		smile.classList.add("milestone__smile");
		smile.classList.add("milestone__smile--target");
		smile.setAttribute("onclick","c.milestone()");
		segment = document.createElement("DIV");
		segment.classList.add("project_chart__segment");
		segment.classList.add("project_chart__segment--placeholder");
		node.appendChild(document.createTextNode("")); // fix
		node.appendChild(smile);
		node.appendChild(document.createTextNode("")); // fix
		node.appendChild(segment);
		return node;
	}

	function newPlaceholderMilestone(){
		node = document.createElement("DIV");
		node.classList.add("milestone");
		node.classList.add("milestone--placeholder");
		smile = document.createElement("DIV");
		smile.classList.add("milestone__smile");
		smile.classList.add("milestone__smile--placeholder");
		segment = document.createElement("DIV");
		segment.classList.add("project_chart__segment");
		segment.classList.add("project_chart__segment--placeholder");
		node.appendChild(document.createTextNode("")); // fix
		node.appendChild(smile);
		node.appendChild(document.createTextNode("")); // fix
		node.appendChild(segment);
		return node;
	}

	this.renderNewMilestone = function(mood) {
		
		// Add constraints for first and last milestone in the path

		// ...

		// Get the active row
		active_row = document.getElementsByClassName("project_chart__row--active")[0];
		// Get the pivots row
		pivots_row = document.getElementsByClassName("project_chart__row--last")[0];
		// Get the active and next milestones
		active_milestone = document.getElementsByClassName("milestone--active")[0];
		next_milestone = document.getElementsByClassName("milestone--next")[0];
		new_next_milestone = next_milestone.nextSibling.nextSibling;

		// Update all the css classes
		active_milestone.classList.remove("milestone--active");
		next_milestone.classList.add("milestone--active");
		next_milestone.classList.remove("milestone--next");
		next_milestone.classList.remove("milestone--placeholder");
		// Update childs --> segments
		next_milestone_segment = next_milestone.childNodes[3];
		next_milestone_segment.classList.remove("project_chart__segment--placeholder");
		// Update childs --> smiles
		next_milestone_smile = next_milestone.childNodes[1];
		next_milestone_smile.classList.remove("milestone__smile--target");

		// Remove the onclick attribute from the milestone
		next_milestone_smile.removeAttribute("onclick");

		// Check if we are at the end of the path
		if(new_next_milestone) {
			
			// Update css classes
			new_next_milestone.classList.add("milestone--next");
			new_next_milestone.classList.remove("milestone--placeholder");
			new_next_milestone_smile = new_next_milestone.childNodes[1];
			new_next_milestone_smile.classList.add("milestone__smile--target");
			new_next_milestone_smile.classList.remove("milestone__smile--placeholder");

			// Add the onclick attribute to the new next milestone
			new_next_milestone_smile.setAttribute("onclick","c.milestone()");	

			// Assign the mood smile to the new milestone
			next_milestone_smile.classList.add("milestone__smile--"+smiles[mood]);
			
		} else {

			// Assign the final smile to the last milestone
			next_milestone_smile.classList.add("milestone__smile--end");

			// Hide the pivots row
			pivots_row.style.display = "none";

			// The milestones are finished !
			alert("Congrats!! You completed all the milestones!");

		}

		// Update project_data array
		for (var i = data[data.length-1].length - 1; i >= 0; i--) {
			if(data[data.length-1][i] != 0) data[data.length-1][i+1] = parseInt(mood);
		}

		return true;
	}

}

// Get current milestone id
Project.prototype.getCurrentMilestoneID = function(){
	// Find the last milestone reached in the current path
	row = this.data[this.data.length-1];
	for (var i = row.length - 1; i >= 0; i--) {
		if(row[i]!=0) return i;
	}
	// If no milestone is found
	return 1;
}

// Get project data
Project.prototype.getData = function() {
	return this.data;
}

p = new Project(3,initial_project_data);
c = new Project_Console(p);


