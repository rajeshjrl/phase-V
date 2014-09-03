<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo (isset($title)) ? $title : $global['site_title']; ?></title>
        <?php $this->load->view('backend/sections/header'); ?>
        <style>
            .error {
                color: #BD4247;
                margin-left: 120px;
                width: 210px;
            }
            .FETextInput{
                margin-left: 120px;
                margin-top: -28px;
            }
        </style>  
        <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>media/backend/js/jquery.validate.min.js"></script>
        <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>media/backend/js/user-manage/edit-user.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>media/front/css/jquery.validate.password.css" />
        <script src="<?php echo base_url(); ?>media/front/js/jquery.validate.password.js"></script>
    </head>
    <body>
        <?php $this->load->view('backend/sections/top-nav.php'); ?>
        <?php $this->load->view('backend/sections/leftmenu.php'); ?>
        <div id="content" class="span10">
            <!--[breadcrumb]-->
            <div>
                <ul class="breadcrumb">
                    <li> <a href="<?php echo base_url(); ?>backend/dashboard">Dashboard</a> <span class="divider">/</span> </li>
                    <li> <a href="<?php echo base_url(); ?>backend/user/list">Manage User</a> <span class="divider">/</span></li>
                    <li> Edit User </li>
                </ul>
            </div>

            <div class="row-fluid sortable"> 
                <!--[sortable header start]-->
                <div class="box span12">
                    <div class="box-header well">
                        <h2><i class=""></i>Edit User</h2>
                        <div class="box-icon">
                            <a title="Manage User" class="btn btn-plus btn-round" href="<?php echo base_url(); ?>backend/user/list"><i class="icon-arrow-left"></i></a>
                        </div>
                    </div>
                    <br >
                    <!--[sortable body]-->
                    <div class="box-content">
                        <form name="frm_user_details" id="frm_user_details" action="<?php echo base_url(); ?>backend/user/edit/<?php echo $edit_id; ?>" method="post">
                            <div class="control-group">
                                <label for="typeahead" class="control-label">User Name<sup class="mandatory">*</sup> </label>
                                <div class="controls">
                                    <input type="text" value=<?php echo str_replace('"', '&quot;', stripslashes($arr_admin_detail['user_name'])); ?> id="user_name" name="user_name" class="FETextInput">
                                    <input type="hidden" value=<?php echo str_replace('"', '&quot;', stripslashes($arr_admin_detail['user_name'])); ?> id="old_username" name="old_username">
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="typeahead" class="control-label">First Name<sup class="mandatory">*</sup> </label>
                                <div class="controls">
                                    <input type="text" value=<?php echo str_replace('"', '&quot;', stripslashes($arr_admin_detail['first_name'])); ?> name="first_name" id="first_name" class="FETextInput">
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="typeahead" class="control-label">Last Name<sup class="mandatory">*</sup> </label>
                                <div class="controls">
                                    <input type="text" value=<?php echo str_replace('"', '&quot;', stripslashes($arr_admin_detail['last_name'])); ?> name="last_name" id="last_name" class="FETextInput">
                                </div>
                            </div>

                            <div class="control-group">
                                <label for="typeahead" class="control-label">Email Id<sup class="mandatory">*</sup> </label>
                                <div class="controls">
                                    <input type="text" value=<?php echo stripslashes($arr_admin_detail['user_email']); ?> name="user_email" id="user_email" class="FETextInput">
                                    <input type="hidden" value=<?php echo stripslashes($arr_admin_detail['user_email']); ?> name="old_email" id="old_email" class="FETextInput">								
                                </div>
                            </div>

                            <div class="control-group">
                                <label for="typeahead" class="control-label">Change Password<sup class="mandatory">*</sup> </label>
                                <div class="controls">
                                    <input type="checkbox" name="change_password" id="change_password">
                                </div>
                            </div>

                            <div id="change_password_div" style="display:none;">
                                <div class="control-group">
                                    <label for="typeahead" class="control-label">New Password<sup class="mandatory">*</sup> </label>
                                    <div class="controls">
                                        <input type="password" id="user_password" name="user_password" class="FETextInput">
                                    </div>

                                    <div style="padding-left: 120px;">
                                        <div class="password-meter">
                                            <div class="password-meter-message password-meter-message-too-short">Too short</div>
                                            <div class="password-meter-bg">
                                                <div class="password-meter-bar password-meter-too-short"></div>
                                            </div>
                                        </div>
                                        <span>
                                            (Password must be combination of atleast 1 number, 1 special character and 1 upper case letter with minimum 8 characters) 
                                        </span>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label for="typeahead" class="control-label">Confirm Password<sup class="mandatory">*</sup> </label>
                                    <div class="controls">
                                        <input type="password" id="confirm_password" name="confirm_password" class="FETextInput">
                                    </div>
                                </div>

                            </div>	 
                            <div class="control-group">
                                <label for="typeahead" class="control-label">Gender<sup class="mandatory">*</sup> </label>
                                <div class="controls" style="margin-top:-25px;margin-left:120px;">								
                                    <span ><input id="gender" type="radio" value="1" name="gender" <?php if ($arr_admin_detail['gender'] == 1) { ?> checked="checked"<?php } ?>>Male
                                        <input id="gender" type="radio" value="2" name="gender" <?php if ($arr_admin_detail['gender'] == 2) { ?> checked="checked"<?php } ?>>Female</span>
                                </div>
                            </div>						
                            <?php
                            if ($arr_admin_detail['role_id'] != 1) {
                                ?>
                                <div class="control-group">
                                    <label for="typeahead" class="control-label">Change Status</label>
                                    <div class="controls">
                                        <select id="user_status" name="user_status" class="FETextInput" style="margin-top:-50px;">
                                            <?php
                                            if ($arr_admin_detail['user_status'] == 0) {
                                                ?>
                                                <option value="">Select Status</option>
                                                <?php
                                            }
                                            ?>
                                            <option value="1" <?php if ($arr_admin_detail['user_status'] == 1) { ?> selected="selected" <?php } ?>>Active</option>
                                            <option value="2" <?php if ($arr_admin_detail['user_status'] == 2) { ?> selected="selected" <?php } ?>>Blocked</option>
                                        </select>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>

                            <div class="form-actions">
                                <button type="submit" name="btn_submit" class="btn btn-primary" value="Save changes">Save Changes</button>
                                <input type="hidden" name="edit_id" id="edit_id" value="<?php echo intval(base64_decode($edit_id)); ?>" />
                            </div>

                        </FORM>
                    </div>
                    <!--[sortable body]--> 
                </div>
            </div>

            <!--[sortable table end]--> 

            <!--[include footer]-->
        </div><!--/#content.span10-->

    </div><!--/fluid-row-->
    <?php $this->load->view('backend/sections/footer.php'); ?>
</div>
</body>
</html>