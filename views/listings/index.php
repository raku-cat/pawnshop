<?=anchor('listings/create', 'Create a listing'); ?><br><br>
<?php if (isset($_SESSION['success']) && $_SESSION['success'] == TRUE) : ?>
<span>Your listing has been created!</span>
<?php endif; ?>
<div class="listings_container">
    <?php foreach ($listings_array as $listing) : ?>
        <div class="individual_listing_container">
            <?=heading(anchor('listings/' . $listing['id'] . '/' . $listing['slug'], mb_strimwidth($listing['title'], 0, 25, '...'), 'title="' . $listing['title'] . '"'), 2, 'class="listing_title"'); ?>
            <?=img(array('src' => $listing['image_thumb'], 'class' => 'listing_image')); ?>
            <?=heading(anchor('/user/' . $listing['user_id'], $listing['username']), 3); ?>
            <p class="listing_description"><?=mb_strimwidth($listing['description'], 0, 20, '...'); ?></p>
            <b style="color: green;"><?=money_format('%.2n', $listing['price']); ?></b>
        </div>
    <?php endforeach; ?>
</div>
