<?=heading('Create a listing', 4); ?>
<span><?=validation_errors(); ?></span><br><br>
<?php if (isset($error)) : ?>
<span><?=$error; ?></span>
<?php endif; ?>
<?=form_open_multipart('listings/create'); ?>
    <?=form_input('form_listing_title', set_value('form_listing_title'), array('id' => 'form_listing_title', 'placeholder' => 'Title', 'maxlength' => '128')); ?><br><br>
    <?=form_textarea('form_listing_description', set_value('form_listing_description'), array('id' => 'form_listing_description', 'placeholder' => 'Description')); ?><br><br>
    <?=form_input('form_listing_price', set_value('form_listing_price'), array('id' => 'form_listing_price', 'placeholder' => 'Price')); ?><br><br>
    <?=form_checkbox('form_listing_nsfw', 'nsfw', false, array('id' => 'form_listing_nsfw')); ?><br><br>
    <?=form_upload(array('name' => 'form_listing_image', 'id' => 'form_listing_image')); ?><br><br>
    <?=form_submit('form_listing_submit', 'Create listing', array('id' => 'form_listing_submit')); ?><br><br>
</form>
