<h2 class="content_title"><img src="<?= $modules_assets ?>fitbit_32.png"> Fitibt</h2>
<ul class="content_navigation">
	<?= navigation_list_btn('home/fitbit', 'Recent') ?>
	<?= navigation_list_btn('home/fitbit/custom', 'Custom') ?>
	<?php if ($logged_user_level_id <= 2) echo navigation_list_btn('home/fitbit/manage', 'Manage', $this->uri->segment(4)) ?>
</ul>