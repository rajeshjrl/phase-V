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
    </head>
    <body>
        <?php $this->load->view('backend/sections/top-nav.php'); ?>
        <?php $this->load->view('backend/sections/leftmenu.php'); ?>
        <div id="content" class="span10">



            <!--[breadcrumb]-->
            <div>
                <ul class="breadcrumb">
                    <li>
                        <!--<a href="javascript:void(0);">Dashboard</a>-->
                        Dashboard
                    </li>
                </ul>
            </div>

            <!--[message box]-->
            <?php
            $msg = $this->session->userdata('msg');
            ?>
            <!--[message box]-->
            <?php if ($msg != '') { ?>
                <div class="msg_box alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" id="msg_close" name="msg_close">x</button>
                    <?php
                    echo $msg;
                    $this->session->unset_userdata('msg');
                    ?> 
                </div>
                <?php
            }
            ?>  

            <?php
            if ($user_account['role_id'] == 1) {
                ?>
                <div class="sortable row-fluid">
                    <a data-rel="tooltip" title="<?php echo $totalCount; ?> Active Admins." class="well span3 top-block" href="<?php echo base_url(); ?>backend/admin/list">
                        <span class="icon32 icon-red icon-user"></span>
                        <div>Total Admin</div>
                        <div><?php echo $totalCount; ?></div>
                        <span class="notification"><?php echo $totalCount; ?></span>
                    </a>
                </div>
                <?php
            } else {
                ?>
                <div class="sortable row-fluid">
                    <a data-rel="tooltip" title="<?php echo $totalCount; ?> Active Admins." class="well span3 top-block" href="javascript:void(0);">
                        <span class="icon32 icon-red icon-user"></span>
                        <div>Total Admin</div>
                        <div><?php echo $totalCount; ?></div>
                        <span class="notification"><?php echo $totalCount; ?></span>
                    </a>
                </div>
                <?php
            }
            ?>		
            <div class="row-fluid sortable">
            </div><!--/row-->

        </div>

        <!--/fluid-row-->
        <?php $this->load->view('backend/sections/footer.php'); ?>
    </div><!--/.fluid-container-->
</body>
</html>