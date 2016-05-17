function upgradeIdea(idea_id){

	if(confirm("Do you really want to upgrade this idea to team?")) {

		url = "./upgrade_ideas.php";
		parameters = "idea_id="+idea_id;
		callback = "upgrade_idea";

		connectPOST(url,parameters,callback);

	}

}

function upgradeIdeaCallback(response){

	alert(response);

	if(confirm("Reload the page to see the changes.")) Location.reload();

}