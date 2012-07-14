<div class="widget_<?= $widget_region ?> widget_fitbit_daily_activity" id="widget_<?= $widget_id ?>">
	<h2><?= $widget_title ?></h2>
	<?php
	// Get Distance 
	$distance_total = 0;
	foreach ($activities_daily->summary->distances as $distance):
		$distance_total = $distance->distance + $distance_total;
	endforeach;
	?>
	<p>
		Today I walked <strong><?= $activities_daily->summary->steps ?> steps / <?= $distance_total ?> miles</strong>. 
		I climbed about <strong><?= $activities_daily->summary->floors ?> floors</strong>.
		I burned about <strong><?= $activities_daily->summary->caloriesOut ?> calories</strong>. 
		I also sat on my arse for about <strong><?= $activities_daily->summary->sedentaryMinutes ?> minutes</strong>.
	</p>
</div>