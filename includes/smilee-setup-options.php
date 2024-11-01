<?php
/**
 * Copyright (c) 2017 Smilee Ltd.
 *
 * Created by @author Samuli Rauatmaa <samuli.rauatmaa@smilee.io>
 */
?>
<div class="wrap">
  <h1 id="title">Smilee Chat</h1>
</div>

<div class="wrap">
	<h4 id="description"><?php _e('Paste the script provided by Smilee', 'smilee-setup');?></h4>
	<form method="post">
    <!-- Add nonce-->
    <?php wp_nonce_field('save_textarea_value','ta_nonce')?>
		<input type="hidden" name="action" value="smilee_save_textarea"/>
		<textarea name="smilee-text-area" rows="10" cols="80" placeholder="<script></script>"><?php $this->smilee_db->smilee_query()?></textarea>
    <p class="submit">
      <?php
  		submit_button(__('Save', 'smilee-setup'), 'primary', 'btn_save_smilee', false);
      submit_button(__('Remove script', 'smilee-setup'), 'secondary', 'btn_remove_smilee', false);
      ?>
    </p>
    <?php $this->smilee_db->echo_confirmation_text()?>
	</form>
</div>
