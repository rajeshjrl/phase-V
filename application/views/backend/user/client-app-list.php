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
        <script src="<?php echo base_url(); ?>media/backend/js/select-all-delete.js"></script> 
    </head>
    <body>
        <?php $this->load->view('backend/sections/top-nav.php'); ?>
        <?php $this->load->view('backend/sections/leftmenu.php'); ?>
        <div id="content" class="span10">
            <!--[breadcrumb]-->
            <div>
                <ul class="breadcrumb">
                    <li> <a href="<?php echo base_url(); ?>backend/dashboard">Dashboard</a> <span class="divider">/</span> </li>
                    <li>Manage Apps</li>
                </ul>
            </div>
            <!--[message box]-->
            <?php
            $msg = $this->session->userdata('msg');
            ?>
            <!--[message box]-->
            <?php if ($msg != '') { ?>
                <div class="msg_box alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" id="msg_close" name="msg_close">×</button>
                    <?php
                    echo $msg;
                    $this->session->unset_userdata('msg');
                    ?> 
                </div>
            <?php } ?>  
            <div class="row-fluid sortable">  
                <!--[sortable header start]-->
                <div class="box span12">
                    <div class="box-header well">
                        <h2><i class=""></i>Apps</h2>
                    </div>
                    <br >
                    <form name="frm_users" id="frm_users" action="<?php echo base_url(); ?>backend/apps" method="post">
                        <!--[sortable body]-->
                        <div class="box-content">
                            <table  class="table table-striped table-bordered bootstrap-datatable datatable">
                                <thead>
                                <th width="7%" class="workcap">
                                    <?php
                                    if (count($arr_app) > 1) {
                                        ?>
                                    <center>Select <br><input type="checkbox" name="check_all" id="check_all"  class="select_all_button_class" value="select all" /></center>
                                    <?php
                                }
                                ?>               
                                </th>
								<th width="" class="workcap">Username</th>
                                <th width="" class="workcap">App name</th>
								<th width="" class="workcap">App Url</th>
                                <th width="" class="workcap">Scope</th>
                                <th width="" class="workcap">Token</th>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($arr_app as $app_client) { ?>
                                    <tr>

                                    <td class="worktd" align="left">
                                    <center><input name="checkbox[]" class="case" type="checkbox" id="checkbox[]" value="<?php echo $app_client['app_id']; ?>" /></center>
                                    </td>
                                    <td class="worktd"  align="left"><?php echo stripslashes($app_client['user_name']); ?></td>
                                    <td class="worktd"  align="left"><?php echo stripslashes($app_client['app_name']); ?></td>
									<td class="worktd"  align="left"><?php echo stripslashes($app_client['url_prefix']); ?></td>
                                    <td class="worktd"  align="left"><?php echo stripslashes($app_client['scope']); ?></td>
                                    <td class="worktd"  align="left"><?php echo stripslashes($app_client['token']); ?></td>
                                    <?php
                                }
                                ?>
                                </tbody>
                                <?php
                                if (count($arr_app) > 0) {
                                    ?>
                                    <tfoot>
                                    <th colspan="9"><input type="submit" id="btn_delete_all" name="btn_delete_all" class="btn btn-danger" onClick="return deleteConfirm();"  value="Delete Selected"></th>
                                    </tfoot>
                                    <?php
                                }
                                ?> 
                            </table>
                        </div>
                        <!--[sortable body]--> 
                    </form>
                </div>
            </div>

            <!--[sortable table end]--> 

            <!--[include footer]-->
        </div><!--/#content.span10-->

    </div><!--/fluid-row-->
    <?php $this->load->view('backend/sections/footer.php'); ?>
</div><!--/.fluid-container-->


</body>
</html>