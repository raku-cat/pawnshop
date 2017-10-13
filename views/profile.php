<b>Welcome <?=$username?> you are a <?=$rank?></b><br>
<?=anchor('logout', 'Log out'); ?><br>
<?php if (isset($codearray)) : ?>
<table class="codes">
    <?php foreach ($codearray as $code) : ?>
        <tr><td><?=$code['code']?></td></tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>
<?php if ($rank == 'admin') : ?>
<b>Admins get a cat</b><br>
<?=img('assets/images/cat.jpg'); ?>
<?php endif; ?>