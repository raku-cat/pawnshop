<div>
    <span><?=validation_errors();?></span>
    <?=form_open('signup');?>
        <input name="invite_code" id="invite_code" placeholder="Invite code" type="text">
        <input name="submit" id="submit" value="submit" type="submit">
    </form>
</div>
