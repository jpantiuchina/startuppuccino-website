<section class="list_view">

	<?php foreach ($teams as $team){ ?>

    	<div class="list_element list_element--team">

    		<div class="team__details">
    			
    			<?php 
                    if(isset($team['pic']) && !file_exists("../app/assets/pics/teams/".$team['pic'])){
        				$team_pic_src = "../app/assets/pics/teams/".$team['pic'];
        			} else {
                        $team_pic_src = "../app/assets/pics/startuppuccino_logo-white.svg";
                    }

                ?>

        		<img src="<?php echo $team_pic_src; ?>" class="team__details_pic" />
    			<h3 class="team__details_title">
	        		<a href="./?team_id=<?php print $team['id']; ?>">
	        			<?php echo $team['name']; ?>
	        		</a>
	        	</h3>
        	</div>

    	</div>

    <?php } // end foreach ?>

</section>