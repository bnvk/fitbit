<h3>Today's Sync</h3>
<?php
// Get Distance 
$distance_total = 0;
foreach ($activities_daily->summary->distances as $distance):
	$distance_total = $distance->distance + $distance_total;
endforeach;
?>
<p>
	<strong>Steps:</strong> <?= $activities_daily->summary->steps ?><br>
	<strong>Floors:</strong> <?= $activities_daily->summary->floors ?><br>
	<strong>Calories:</strong> <?= $activities_daily->summary->caloriesOut ?><br>
	<strong>Distance:</strong> <?= $distance_total ?> miles<br>
	I sat on my arse for <strong><?= $activities_daily->summary->sedentaryMinutes ?> minutes</strong><br>
	I was lightly active for <strong><?= $activities_daily->summary->lightlyActiveMinutes ?> minutes</strong><br> 
	I was fairly active for <strong><?= $activities_daily->summary->fairlyActiveMinutes ?> minutes</strong><br> 
	I was really active for <strong><?= $activities_daily->summary->veryActiveMinutes ?> minutes</strong>
</p>
<br>

<h3>All Time</h3>

<p>
	<strong>Steps:</strong> <?= $activities->lifetime->total->steps ?><br>
	<strong>Floors:</strong> <?= $activities->lifetime->total->floors ?><br>
	<strong>Calories:</strong> <?= $activities->lifetime->total->caloriesOut ?><br>
	<strong>Distance:</strong> <?= $activities->lifetime->total->distance ?> miles
</p>