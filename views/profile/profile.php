<b>Welcome <?=$username?> you are a <?=$rank?></b><br>
<?=anchor('logout', 'Log out'); ?><br>
<?php if (isset($result)) : ?><span><?=$result?><?php endif; ?>
<?php if ($invites_left > 0) : ?>
<br><div class="invite">
    <b>Invite someone!</b><br>
    <span>Invites left: <?=$invites_left?></span>
    <span><?=validation_errors(); ?></span><br>
    <?=form_open('profile'); ?>
        <input name="invite_email" id="invite_email" placeholder="Email" type="email">
        <input name="invite" id="invite" value="Invite" type="submit">
    </form>
</div>
<?php endif; ?>
<?php if ($rank == 'admin') : ?>
<b>Admins get a cat</b><br>
<?=img('assets/images/cat.jpg'); ?>
<?php endif; ?>