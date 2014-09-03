<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo (isset($title)) ? $title : $global['site_title']; ?></title>
        <?php
        $this->load->view('backend/sections/header');
        ?>
        <style>
            .error {
                color: #BD4247;
                margin-left: 35px;
                text-align: left;
                width: 150px;
            }
            .alert{
                padding:8px 0px;
            }
        </style>
        <script src="<?php echo base_url(); ?>media/backend/js/jquery.dataTables.min.js"></script> 
        <script src="<?php echo base_url(); ?>media/backend/js/bootstrap-tab.js"></script>
        <!-- library for advanced tooltip -->
        <script src="<?php echo base_url(); ?>media/backend/js/bootstrap-tooltip.js"></script>
        <script src="<?php echo base_url(); ?>media/backend/js/charisma.js"></script>
        <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>media/backend/js/jquery.validate.js"></script>
        <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>media/backend/js/login/admin-login.js"></script>
    </head>
    <body>

        <div class="row-fluid">
            <div class="span12 center login-header">
                <h2>Welcome to Administrator</h2>
            </div><!--/span-->
        </div><!--/row-->

        <div class="row-fluid">
            <div class="well span5 center login-box">
                <div class="alert alert-info">
                    Login with your Username and Password.
                </div>
                <!-- [start : admin interface message] -->
                <!--[message box]-->
                <?php
                $msg = $this->session->userdata('msg');
                $this->session->unset_userdata('msg');
                if (isset($msg) != '') {
                    echo $msg;
                }
                ?>      
                <!-- [end  : admin interface message] -->
                <form name="frm_admin_login" id="frm_admin_login" class="form-horizontal" action="<?php echo base_url(); ?>backend/login" method="post">
                    <fieldset>
                        <div class="input-prepend" title="Username" data-rel="tooltip">
                            <span class="add-on"><i class="icon-user"></i></span>
                            <input autofocus class="input-large span10" type="text" name="user_name" size="" id="user_name" value="" placeholder="Username" >                    
                        </div>
                        <div class="clearfix"></div>
                        <div class="input-prepend" title="Password" data-rel="tooltip">
                            <span class="add-on"><i class="icon-lock"></i></span>                    
                            <input autofocus class="input-large span10" type="password" name="user_password" id="user_password" value="" placeholder="Password" >                    
                        </div>
                        <div class="clearfix"></div>
                        <div class="clearfix"></div>
                        <div class="clearfix"></div>
                        <div class="input-prepend">
                            Forgot Password? <a href="<?php echo base_url(); ?>backend/forgot-password">click here</a>                    
                        </div>

                        <div class="clearfix"></div>

                        <p class="center span5">
                            <input type="submit" class="btn btn-primary" value="Login">
                        </p>
                    </fieldset>
                </form>
            </div><!--/span-->
        </div><!--/row-->


