function generalEducatorsCallback(response){

	alert(response);

	if(confirm("Reload the page to see the changes.")){
		window.location='./idea_approve.php';
	}

}

function upgradeIdea(idea_id){

	if(confirm("Do you really want to upgrade this idea to team?")) {
		connectPOST("./upgrade_ideas.php","idea_id="+idea_id,"upgrade_idea");
	}

}

function approve(idea_id){
	connectPOST("./idea_approve_controller.php","idea_id="+idea_id+"&action=approve","approve_idea");
}

function disapprove(idea_id){
	connectPOST("./idea_approve_controller.php","idea_id="+idea_id+"&action=disapprove","disapprove_idea");	
}