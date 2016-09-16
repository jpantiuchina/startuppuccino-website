<section id="search" class="search">

	<div class="search__header">

		<input type="text" placeholder="..." id="search_input"/>
		
		<span class="tempclose" onclick="Sp.layout.toggleSearch(true)">X</span>

		<div class="search_filters">
			<span id="search_filter__people">People</span>
			<span id="search_filter__ideas">Ideas</span>
		</div>

	</div>

	<div class="search__main search__main--list" id="search_result_list">

		<div class="search_results">

			<div class="search_result">
				<a>
					<img src="" class="search_result__pic" />
					<p class="search_result__name"></p>
					<p class="search_result__role"></p>
				</a>
			</div>

		</div>

	</div>

</section>
