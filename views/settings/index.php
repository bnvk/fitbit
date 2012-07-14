<form name="settings_update" id="settings_update" method="post" action="<?= base_url() ?>api/settings/modify" enctype="multipart/form-data">
<div class="content_wrap_inner">

	<div class="content_inner_top_right">
		<h3>App</h3>
		<p><?= form_dropdown('enabled', config_item('enable_disable'), $settings['fitbit']['enabled']) ?></p>
		<p><a href="<?= base_url() ?>api/<?= $this_module ?>/uninstall" id="app_uninstall" class="button_delete">Uninstall</a></p>
	</div>
	
	<h3>Application Keys</h3>

	<p>Fitbit requires <a href="https://dev.fitbit.com/apps/new" target="_blank">registering your application</a></p>
				
	<p><input type="text" name="consumer_key" value="<?= $settings['fitbit']['consumer_key'] ?>"> Consumer Key </p> 
	<p><input type="text" name="consumer_secret" value="<?= $settings['fitbit']['consumer_secret'] ?>"> Consumer Secret</p>

</div>

<span class="item_separator"></span>

<div class="content_wrap_inner">

	<h3>Social</h3>

	<p>Connections 
	<?= form_dropdown('social_connection', config_item('yes_or_no'), $settings['fitbit']['social_connection']) ?>
	</p>

	<p>Connections Redirect<br>
	<?= base_url() ?> <input type="text" size="30" name="connections_redirect" value="<?= $settings['fitbit']['connections_redirect'] ?>" />
	</p>

	<input type="hidden" name="module" value="<?= $this_module ?>">

	<p><input type="submit" name="save" value="Save" /></p>

</div>
</form>

<?= $shared_ajax ?>