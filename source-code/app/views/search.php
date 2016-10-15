<section id="search" class="search">

	<div class="search__header">

		<input type="text" placeholder="Type here.." id="search_input"/>
		
		<span class="tempclose" onclick="Sp.layout.toggleSearch(true)">x</span>

	</div>

	<div class="search__filters">
		<div class="search__filters__reset" data-filter="ideas">
			<div class="search__filters__content">
				<span class="search__filters__all search__filters__item search__filters__item--selected" data-filter="reset">All Results</span>
			</div>
		</div>
		<div class="search__filters__people">
			<div class="search__filters__content">
				<span class="search__filters__all search__filters__item" data-filter="people">All Users</span>
				<span class="search__filters__students search__filters__item" data-filter="student">Students</span>
				<span class="search__filters__mentors search__filters__item" data-filter="mentor">Mentors</span>
				<span class="search__filters__educators search__filters__item" data-filter="educator">Teachers</span>
			</div>
		</div>
		<div class="search__filters__ideas" data-filter="ideas">
			<div class="search__filters__content">
				<span class="search__filters__all search__filters__item" data-filter="idea">Ideas</span>
			</div>
		</div>
	</div>

	<div class="search__main search__main--list" id="search_result_list">

		<div class="search_results">

			<div class="search_result">
				
			</div>

		</div>

	</div>

</section>
