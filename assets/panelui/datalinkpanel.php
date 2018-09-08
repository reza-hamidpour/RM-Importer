<div class="wrap">
    <form action="#" method="POST">
        <table class="form-table" style="width:600px; background:#fff; padding:10px; border:1px solid #ddd;">
            <tr><td><h1 style="margin-bottom:15px;">Data Link GONFIG:</h1></td></tr>
            <tr><td> Username:</td><td><input type="text" name="dl_token" cols="50" value="<?php echo get_option('rmi_username'); ?>" placeholder="insert token of datalink"/></td></tr>
            <tr><td> Password:</td><td><input type="email" name="dl_email" cols="50" value="<?php echo get_option("rmi_password"); ?>" placeholder="insert datalink email address"/></td></tr>
            <tr><td><input type="submit" value="syncs" class=" btn-lg btn-info" name="sync_with_data_link" /></td><td><input type="submit" value="save" name="save_data"/></td></tr>
        </table>
    </form>
</div>