<form name="settings_update" id="settings_update" method="post" action="<?= base_url() ?>api/settings/modify" enctype="multipart/form-data">
<div class="content_wrap_inner">

	<div class="content_inner_top_right">
		<h3>App</h3>
		<p><?= form_dropdown('enabled', config_item('enable_disable'), $settings['fitbit']['enabled']) ?></p>
		<p><a href="<?= base_url() ?>api/<?= $this_module ?>/uninstall" id="app_uninstall" class="button_delete">Uninstall</a></p>
	</div>
	
	<h3>Permissions</h3>

	<p>Create
	<?= form_dropdown('create_permission', config_item('users_levels'), $settings['fitbit']['create_permission']) ?>
	</p>

	<p>Publish
	<?= form_dropdown('publish_permission', config_item('users_levels'), $settings['fitbit']['publish_permission']) ?>	
	</p>

	<p>Manage All
	<?= form_dropdown('manage_permission', config_item('users_levels'), $settings['fitbit']['manage_permission']) ?>	
	</p>
		
<div class="content_wrap_inner">

	<h3>Social</h3>

	<p>Connections 
	<?= form_dropdown('social_connection', config_item('yes_or_no'), $settings['fitbit']['social_connection']) ?>
	</p>

	<p>Connections Redirect<br>
	<?= base_url() ?> <input type="text" size="30" name="connections_redirect" value="<?= $settings['fitbit']['connections_redirect'] ?>" />
	</p>

	<p>Archive Data
	<?= form_dropdown('archive', config_item('yes_or_no'), $settings['fitbit']['archive']) ?>
	</p>

	<input type="hidden" name="module" value="<?= $this_module ?>">

	<p><input type="submit" name="save" value="Save" /></p>

</div>
</form>

<?= $shared_ajax ?>