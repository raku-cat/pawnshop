<div>
    <span><?=validation_errors();?></span>
    <?=form_open('signup');?>
        <input name="access_code" id="access_code" placeholder="Access code" type="text">
        <input name="submit" id="submit" value="submit" type="submit">
    </form>
</div>
