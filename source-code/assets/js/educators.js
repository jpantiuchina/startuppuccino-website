function upgradeIdea(idea_id){

	url = "./upgrade_ideas.php";
	parameters = "idea_id="+idea_id;
	callback = "upgrade_idea";

	connectPOST(url,parameters,callback);

}

function upgradeIdeaCallback(response){

	alert(response);

	if(confirm("Reload the page to see the changes.")) Location.reload();

}