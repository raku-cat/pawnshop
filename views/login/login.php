<div class="login">
    <span><?=validation_errors();?></span>
    <?php if (isset($error)) :?>
    <span><?=$error?></span>
    <?php endif;?>
    <?=form_open('login'); ?>
        <table>
            <tr><td align="left"><input id="email" name="email" placeholder="Email" type="text"></td></tr>
            <tr><td align="left"><input id="pass" name="password" placeholder="password" type="password"></td></tr>
            <tr><td><input id="login" name="login" type="submit" value="login"></td></tr>
        </table>
    </form>
</div>
<?=anchor('signup', 'Sign Up'); ?>