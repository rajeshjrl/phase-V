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
        <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>media/backend/js/admin-manage/add-admin.js"></script>
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
                    <li> <a href="<?php echo base_url(); ?>backend/admin/list">Manage Admin</a> <span class="divider">/</span></li>
                    <li> Add Admin User </li>
                </ul>
            </div>
            <div class="row-fluid sortable"> 
                <!--[sortable header start]-->
                <div class="box span12">
                    <div class="box-header well">
                        <h2><i class=""></i>Add Admin User</h2>
                        <div class="box-icon">
                            <a title="Manage Admin" class="btn btn-plus btn-round" href="<?php echo base_url(); ?>backend/admin/list"><i class="icon-arrow-left"></i></a>
                        </div>
                    </div>
                    <br >
                    <!--[sortable body]-->
                    <div class="box-content">
                        <form name="frm_admin_details" id="frm_admin_details" action="<?php echo base_url(); ?>backend/admin/add" method="POST" >
                            <div class="control-group">
                                <label for="typeahead" class="control-label">Username<sup class="mandatory">*</sup> </label>
                                <div class="controls">
                                    <input type="text" value="" id="user_name" name="user_name" class="FETextInput">
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="typeahead" class="control-label">Real Name<sup class="mandatory"></sup> </label>
                                <div class="controls">
                                    <input type="text" value="" name="first_name" id="first_name" class="FETextInput">
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="typeahead" class="control-label">Email Id<sup class="mandatory">*</sup> </label>
                                <div class="controls">
                                    <input type="text" value="" name="user_email" id="user_email" class="FETextInput">
                                </div>
                            </div>

                            <div class="control-group">
                                <label for="typeahead" class="control-label">Password<sup class="mandatory">*</sup> </label>
                                <div class="controls">
                                    <input type="password" id="user_password" name="user_password" class="FETextInput">

                                    <div style="padding-left: 120px;">
                                        <div class="password-meter" style="display:none">
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
                            </div>

                            <div class="control-group">
                                <label for="typeahead" class="control-label">Confirm Password<sup class="mandatory">*</sup> </label>
                                <div class="controls">
                                    <input type="password" id="confirm_password" name="confirm_password" class="FETextInput">
                                </div>
                            </div>

                            <div class="control-group">
                                <label for="typeahead" class="control-label">Choose Admin <br> Role<sup class="mandatory">*</sup> </label>

                                <div class="controls">
                                    <select id="role_id" name="role_id" class="FETextInput" style="margin-top:-50px;">
                                        <option value="">Select Role</option>
                                        <?php
                                        foreach ($arr_roles as $key => $role) {
                                            if ($role['role_id'] != 1) {
                                                ?>
                                                <option value="<?php echo $role['role_id']; ?>"><?php echo $role['role_name']; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div id="pre_div">

                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" name="btn_submit" class="btn btn-primary" value="Save changes">Save changes</button>
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