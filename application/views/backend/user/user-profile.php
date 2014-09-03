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

            .controls-text {
                margin-left: 160px;
                margin-top: 6px;
            }
            .form-horizontal .control-label{
                font-weight:bold;
            }
        </style>  
        <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>media/backend/js/jquery.validate.min.js"></script>
    </head>
    <body>
        <?php $this->load->view('backend/sections/top-nav.php'); ?>
        <?php $this->load->view('backend/sections/leftmenu.php'); ?>
        <div id="content" class="span10">
            <!--[breadcrumb]-->
            <div>
                <ul class="breadcrumb">
                    <li><a href="<?php echo base_url(); ?>backend/dashboard">Dashboard</a> <span class="divider">/</span> </li>
                    <?php
                    $user_account = $this->session->userdata('user_account');
                    if ($user_account['role_id'] == 1) {
                        ?>
                        <li> <a href="<?php echo base_url(); ?>backend/user/list">Manage User</a> <span class="divider">/</span></li>
                        <?php
                    }
                    ?>
                    <li>User Profile </li>
                </ul>
            </div>

            <div class="row-fluid sortable"> 
                <!--[sortable header start]-->
                <div class="box span12">
                    <div class="box-header well">
                        <h2><i class=""></i>User Profile</h2>
                        <div class="box-icon">
                            <a title="Go Back" class="btn btn-plus btn-round" onClick="history.go(-1);" href="javascript:void(0);"><i class="icon-arrow-left"></i></a>
                        </div>
                    </div>
                    <br >
                    <!--[sortable body]-->
                    <div class="box-content">
                        <form id="frm_admin_dtl" class="form-horizontal" name="frm_admin_dtl">
                            <div class="control-group">
                                <label for="typeahead" class="control-label">User Name</label>
                                <div class="controls-text">
                                    <?php echo $arr_user_detail['user_name']; ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="typeahead" class="control-label">Real Name</label>
                                <div class="controls-text">
                                    <?php echo $arr_user_detail['first_name']; ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="typeahead" class="control-label">Email Id </label>
                                <div class="controls-text">
                                    <?php echo $arr_user_detail['user_email']; ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <label for="typeahead" class="control-label">Register Date</label>

                                <div class="controls-text">
                                    <?php echo date($global['date_format'], strtotime($arr_user_detail['register_date'])); ?>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button onClick="history.go(-1);" class="btn" id="btn_cancel" name="btn_cancel" type="button">Back</button>
                            </div>


                        </form>
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