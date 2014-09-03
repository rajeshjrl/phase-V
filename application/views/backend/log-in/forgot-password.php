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
        <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>media/backend/js/login/forgot-password.js"></script>
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
                <h2>Forgot Password</h2>
            </div><!--/span-->
        </div><!--/row-->

        <div class="row-fluid">
            <div class="well span5 center login-box">
                <div class="alert alert-info">
                    Enter your registered email address.
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
                <form name="frm_admin_forgot_password" id="frm_admin_forgot_password" class="form-horizontal" action="<?php echo base_url(); ?>backend/forgot-password" method="post">
                    <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>" />
                    <fieldset>
                        <div class="input-prepend" title="Email" data-rel="tooltip">
                            <span class="add-on"><i class="icon-user"></i></span>
                            <input autofocus class="input-large span10" type="text" name="user_email" size="" id="user_email" value="" placeholder="Email">                             
                        </div>
                        <div class="clearfix"></div>
                        <div class="clearfix"></div>               
                        <div class="clearfix"></div>
                        <div class="clearfix"></div>				
                        <p class="center span5">                    
                            <button type="button" name="btn_back" value="btn_back"  class="btn btn-primary" onClick="javascript:window.location='<?php echo base_url(); ?>backend/login';" style="width: 65px;">Back</button>      
                            <button type="submit" name="btn_submit" class="btn btn-primary" value="Submit">Submit</button>             
                        </p>
                        <div class="clearfix"></div>
                    </fieldset>
                </form>
            </div><!--/span-->
        </div><!--/row-->


