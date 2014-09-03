<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo (isset($title)) ? $title : $global['site_title']; ?></title>
        <?php $this->load->view('backend/sections/header'); ?>
        <script src="<?php echo base_url(); ?>media/backend/js/jquery.dataTables.min.js"></script> 
        <script src="<?php echo base_url(); ?>media/backend/js/bootstrap-tab.js"></script>
        <!-- library for advanced tooltip -->
        <script src="<?php echo base_url(); ?>media/backend/js/bootstrap-tooltip.js"></script>
        <script src="<?php echo base_url(); ?>media/backend/js/charisma.js"></script>
        <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>media/backend/js/jquery.validate.js"></script>
        <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>media/front/js/jquery.validate.password.js"></script>
        <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>media/backend/js/login/reset-admin-password.js"></script>
        <style>
            .error {
                color: #BD4247;
                margin-left: 35px;
                text-align: left;
                width: 150px;
            }
            .login-box .btn{
                width:35%;
            }
        </style>
    </head>
    <body>

        <div class="row-fluid">
            <div class="span12 center login-header">
                <h2>Reset Password</h2>
            </div><!--/span-->
        </div><!--/row-->        
        <div class="row-fluid">
            <div class="well span5 center login-box">
                <div class="alert alert-info">
                    Reset your password here.
                </div>
                <!-- [start : admin interface message] -->
                <!--[message box]-->
                <?php
                $msg = $this->session->userdata("msg");
                if ($msg != '') {
                    echo $msg;
                    $this->session->uset_userdata("msg");
                }
                ?>      
                <!-- [end  : admin interface message] -->
                <form name="frm_admin_reset_password" id="frm_admin_reset_password" class="form-horizontal" action="<?php echo base_url(); ?>backend/reset-admin-password-action" method="post">                    
                    <input type="hidden" name="activation_code" id="activation_code" value="<?php echo $arr_user_data['activation_code']; ?>" />
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $arr_user_data['user_id']; ?>" />
                    <fieldset class="reset_pass">
                        <div class="input-prepend" title="new password" data-rel="tooltip">

                            <input autofocus class="input-large span10" type="password" name="new_password" size="" id="new_password" value="" placeholder="New password" >                    
                        </div>
                        <div class="clearfix"></div>                        
                        <div class="input-prepend" title="confirm password" data-rel="tooltip">

                            <input autofocus class="input-large span10" type="password" name="cnf_password" size="" id="cnf_password" value="" placeholder="Confirm password" >                    
                        </div>

                        <div class="clearfix"></div>
                        <div class="clearfix"></div>               
                        <div class="clearfix"></div>
                        <div class="clearfix"></div>				
                        <p class="center span5">                    
                            <!--<button type="button" name="btn_back" value="btn_back"  class="btn btn-primary" onClick="javascript:window.location='<?php echo base_url(); ?>backend/login';" style="width: 65px;">Back</button>-->      
                            <button type="submit" name="btn_frgt_pwd" class="btn btn-primary" value="Submit">Submit</button>             
                        </p>
                        <div class="clearfix"></div>
                    </fieldset>
                </form>
            </div><!--/span-->
        </div><!--/row-->


