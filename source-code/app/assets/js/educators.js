
var educatorsCallback = function(response){

	alert(response);

	if( confirm("Reload the page to see the changes.") ){
		window.location = './idea_approve.php';
	}

}

function upgradeIdea(idea_id){

	if( confirm("Do you really want to upgrade this idea to team?") ) {
		Sp.post({url : "./upgrade_ideas.php", parameters : "idea_id="+idea_id}, educatorsCallback);
	}

}

function approve(idea_id){

	Sp.post({url : "./idea_approve_controller.php", parameters : "idea_id="+idea_id+"&action=approve"}, educatorsCallback);

}

function disapprove(idea_id){

	Sp.post({url : "./idea_approve_controller.php", parameters : "idea_id="+idea_id+"&action=disapprove"}, educatorsCallback);	

}