<section id="search" class="search">

	<div class="search__header">

		<input type="text" placeholder="Type here.." id="search_input"/>
		
		<span class="tempclose" onclick="Sp.layout.toggleSearch(true)">x</span>

	</div>

	<div class="search__filters">
		<div class="search__filters__people">
			<div class="search__filters__content">
				<span class="search__filters__all" data-filter="people">All Users</span>
				<span class="search__filters__students" data-filter="students">Students</span>
				<span class="search__filters__mentors" data-filter="mentors">Mentors</span>
				<span class="search__filters__educators" data-filter="educators">Teachers</span>
			</div>
		</div>
		<div class="search__filter__ideas" data-filter="ideas">
			<div class="search__filters__content">
				<span class="search__filters__all" data-filter="ideas">Ideas</span>
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
