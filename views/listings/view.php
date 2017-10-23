<?=anchor(base_url('/listings'), '<< Back'); ?>
<div class="listing_view">
    <?=heading($listings_array['title'] , 2, 'class="listing_view_title"'); ?>
    <?=img(array('src' => $listings_array['image'], 'class' => 'listing_view_image')); ?>
    <?=heading(anchor('/user/' . $listings_array['user_id'], $listings_array['username']), 3); ?>
    <b style="color: green;"><?=money_format('%.2n', $listings_array['price']); ?></b>
    <p class="listing_view_description"><?=$listings_array['description']; ?></p>
</div>
