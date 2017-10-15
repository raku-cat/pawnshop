<div>
    <span><?=validation_errors();?></span>
    <?php if (isset($error)) :?>
    <span><?=$error?></span>
    <?php endif;?>
    <?=form_open('signup');?>
        <input name="email" id="email" placeholder="Email" value="<?php if (isset($email)) { echo $email; } else { echo set_value('email'); }?>" type="text">
        <input name="username" id="user" placeholder="Username" value="<?=set_value('username');?>" type="text">
        <input name="password" id="pass" placeholder="Password" value="<?=set_value('password');?>" type="password">
        <input name="password_confirm" id="pass" placeholder="Confirm Password" type="password">
        <input name="signup" id="signup" type="submit" value="Sign Up">
    </form>
</div>
