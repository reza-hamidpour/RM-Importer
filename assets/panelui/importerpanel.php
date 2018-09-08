<div class="wrap">
    <form action="#" method="POST">
        <table class="form-table" style="width:600px; background:#fff; padding:10px; border:1px solid #ddd;">
            <tr><td><h1 style="margin-bottom:15px;">RMPRO GONFIG:</h1></td></tr>
            <tr><td> Username:</td><td><input type="text" name="rmi_username" cols="50" value="<?php echo get_option('rmi_username'); ?>"/></td></tr>
            <tr><td> Password:</td><td><input type="text" name="rmi_pass" cols="50" value="<?php echo get_option("rmi_password"); ?>"/></td></tr>
            <tr><td> Application:</td><td><input type="text" name="rmi_application" cols="50" value="<?php echo get_option("rmi_application"); ?>"/></td></tr>
            <tr><td> Server:</td><td><input type="text" name="rmi_server" cols="50" value="<?php echo get_option("rmi_server"); ?>"/></td></tr>
            <tr><td> Port Number:</td><td><input type="text" name="rmi_port_number" cols="50" value="<?php echo get_option("rmi_port_num"); ?>"/></td></tr>
            <tr><td>Access Code:</td><td><input type="text" name="rmi_acc_code" cols="50" value="<?php echo get_option("rmi_acc_code"); ?>"/></td></tr>
            <tr><td>Access Key:</td><td><input type="text" name="rmi_acc_key" cols="50" value="<?php echo get_option("rmi_acc_key"); ?>"/></td></tr>
            <tr><td>Content Type:</td><td><input type="text" name="rmi_content_type" cols="50" value="<?php echo get_option("rmi_content_type"); ?>"/></td></tr>
            <tr><td><input type="submit" value="syncs" class=" btn-lg btn-info" name="sync_with_server" /></td><td><input type="submit" value="save" name="save_data"/></td></tr>
        </table>
    </form>
</div>
<?php if(isset($_POST['rmi_username']) && !empty($_POST['rmi_username']))
        {
        isset($_POST['rmi_username'])?update_option('rmi_username'):null;
        isset($_POST['rmi_password'])?update_option('rmi_passowrd'):null;
        isset($_POS['rmi_server'])?update_option('rmi_server'):null;
        isset($_POST['rmi_port_num'])?update_option('rmi_port_num'):null;
        isset($_POST['rmi_acc_code'])?update_option('rmi_acc_code'):null;
        isset($_POST['rmi_acc_key'])?update_option('rmi_acc_key'):null;
        isset($_POST['rmi_content_type'])?update_option('rmi_content_type'):null;
        } ?>