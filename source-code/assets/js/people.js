/* Filters functions */

var old_target;

function filterResults(target, button){

	// toggle styles of filter buttons
	button.classList.toggle("filter_menu__button--active");
	if(old_target && old_target != target) {

		other_filter = document.getElementById("filter_button--"+old_target);

		if(other_filter.classList.contains("filter_menu__button--active"))
			other_filter.classList.toggle("filter_menu__button--active");

		renderUserCards(target);

	} else if (old_target){

		renderAllUserCards();

	} else {

		renderUserCards(target);

	}

	// store new filter target
	if(old_target != target)
		old_target = target;

}

function renderUserCards(target){
	// toggle cards visibility
	cards = document.getElementsByClassName("user_card");
	for (var i = cards.length - 1; i >= 0; i--) {
		if (cards[i].classList.contains("user_card--"+target))
			cards[i].classList.remove("user_card--hidden");
		else
			cards[i].classList.add("user_card--hidden");
	}
}

function renderAllUserCards(){
	cards = document.getElementsByClassName("user_card");
	for (var i = cards.length - 1; i >= 0; i--) {
		cards[i].classList.remove("user_card--hidden");
	}
}