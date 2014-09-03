<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo (isset($title)) ? $title : $global['site_title']; ?></title>
        <?php $this->load->view('backend/sections/header'); ?>
        <style>
            div.error {
                color: #BD4247;
                margin-left: 120px;
                width: 250px;
                margin-top:-10px;
            }
            .FETextInput{
                margin-left: 120px;
                margin-top: -28px;
            }
        </style>  
        <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>media/backend/js/jquery.validate.min.js"></script>
        <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>media/backend/js/admin-manage/edit-admin.js"></script>
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
                    <li> Update Profile</li>
                </ul>
            </div>

            <div class="row-fluid sortable"> 
                <!--[sortable header start]-->
                <div class="box span12">
                    <div class="box-header well">
                        <h2><i class=""></i>Update Profile</h2>
                        <div class="box-icon">
                            <a title="Go Back" class="btn btn-plus btn-round" onClick="history.go(-1);" href="javascript:void(0);"><i class="icon-arrow-left"></i></a>
                        </div>
                    </div>
                    <br >
                    <!--[sortable body]-->
                    <div class="box-content">
                        <form name="frm_admin_details" id="frm_admin_details" action="<?php echo base_url(); ?>backend/admin/edit-profile" method="POST">
                            <div class="control-group">
                                <label for="typeahead" class="control-label">User Name<sup class="mandatory">*</sup> </label>
                                <div class="controls">
                                    <input type="text" value="<?php echo str_replace('"', '&quot;', stripslashes($arr_admin_detail['user_name'])); ?>" id="user_name" name="user_name" class="FETextInput">
                                    <input type="hidden" value="<?php echo str_replace('"', '&quot;', stripslashes($arr_admin_detail['user_name'])); ?>" id="old_username" name="old_username">
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="typeahead" class="control-label">Real Name<sup class="mandatory"></sup> </label>
                                <div class="controls">
                                    <input type="text" value="<?php echo str_replace('"', '&quot;', stripslashes($arr_admin_detail['first_name'])); ?>" name="first_name" id="first_name" class="FETextInput">
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="typeahead" class="control-label">Email Id<sup class="mandatory">*</sup> </label>
                                <div class="controls">
                                    <input type="text" value="<?php echo stripslashes($arr_admin_detail['user_email']); ?>" name="user_email" id="user_email" class="FETextInput">
                                    <input type="hidden" value="<?php echo stripslashes($arr_admin_detail['user_email']); ?>" name="old_email" id="old_email" class="FETextInput">								
                                </div>
                            </div>

                            <div class="control-group">
                                <label for="typeahead" style="width:175px;" class="control-label">Change Password<sup class="mandatory">*</sup>  <div class="controls" style="width: 50px; float: right; margin-left: 12px;">
                                        <input type="checkbox" name="change_password" id="change_password" style="margin-top: 3px;">
                                    </div> </label>

                            </div>

                            <div id="change_password_div" style="display:none;">
                                <div class="control-group">
                                    <label for="typeahead" class="control-label">New Password<sup class="mandatory">*</sup> </label>
                                    <div class="controls">
                                        <input type="password" id="user_password" name="user_password" class="FETextInput">
                                    </div>

                                    <div style="padding-left: 120px;">

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
                            <div class="form-actions">
                                <button type="submit" name="btn_submit" class="btn btn-primary" value="Save changes">Save Changes</button>
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