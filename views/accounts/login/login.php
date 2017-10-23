<div class="login">
    <span><?=validation_errors();?></span>
    <?php if (isset($error)) :?>
    <span><?=$error?></span>
    <?php endif;?>
    <?=form_open('login', 'class=login_form'); ?>
        <table>
            <tr><td align="left"><?=form_email(array('id' =>'email', 'name' => 'email', 'placeholder' => 'Email')); ?></td></tr>
            <tr><td align="left"><?=form_password(array('id' => 'pass', 'name' => 'password', 'placeholder' => 'password')); ?></td></tr>
            <tr><td><?=form_submit('login', 'login', array('id' => 'login')); ?></td></tr>
        </table>
    </form>
</div>
<?=anchor('signup', 'Sign Up'); ?>