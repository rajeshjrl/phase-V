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
                    <li> Manage Roles</li>
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
                <?php
            }
            ?>       <div class="row-fluid sortable">   
                <!--[sortable header start]-->
                <div class="box span12">
                    <div class="box-header well">
                        <h2><i class=""></i>Roles Management</h2>
                        <div class="box-icon">
                            <a title="Add new Role" class="btn btn-plus btn-round" href="<?php echo base_url(); ?>backend/role/add"><i class="icon-plus"></i></a>
                        </div>
                    </div>
                    <br >
                    <form name="frm_roles" id="frm_roles" action="<?php echo base_url() ?>backend/role/list" method="post">
                        <!--[sortable body]-->
                        <div class="box-content">
                            <table  class="table table-striped table-bordered bootstrap-datatable datatable">
                                <thead>
                                <th width="7%" class="workcap">	
                                <center> Select 
                                    <br>
                                    <?php
                                    if (count($arr_roles) > 1) {
                                        ?>
                                        <input type="checkbox" name="check_all" id="check_all"  class="select_all_button_class" value="select all" />
                                        <?php
                                    }
                                    ?>
                                </center>				 	
                                </th>



                                <th width="43%" class="workcap">Role Name</th>
                                <th width="20%" class="workcap" align="center">Action</th>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($arr_roles as $roles) {
                                        ?>
                                        <tr>
                                         <!-- <td class="worktd" align="left"><center><input value="<?php echo $roles['role_id']; ?>" class="chkselect" type="checkbox"></center></td>-->
                                            <td class="worktd" align="left">
                                                <?php
                                                if ($roles['role_id'] != 1) {
                                                    ?>
                                        <center><input name="checkbox[]" class="case" type="checkbox" id="checkbox[]" value="<?php echo $roles['role_id']; ?>" /></center>
                                        <?php
                                    }
                                    ?>
                                    </td>
                                    <td class="worktd"  align="left"><?php echo stripslashes($roles['role_name']); ?></td>
                                    <td class="worktd">
                                        <?php
                                        if ($roles['role_id'] != 1) {
                                            ?>
                                            <a class="btn btn-info" href="<?php echo base_url(); ?>backend/role/edit/<?php echo base64_encode($roles['role_id']); ?>" title="Edit Role">
                                                <i class="icon-edit icon-white"></i>Edit</a> 
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <?php
                                }
                                ?>
                                </tbody>
                                <?php
                                if (count($arr_roles) > 1) {
                                    ?>
                                    <tfoot>
                                    <th colspan="6">
                                        <input type="submit" id="btn_delete_all" name="btn_delete_all" class="btn btn-danger" onClick="return deleteConfirm();"  value="Delete Selected"></th>
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