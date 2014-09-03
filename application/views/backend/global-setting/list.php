<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo (isset($title)) ? $title : $global['site_title']; ?></title>
        <?php $this->load->view('backend/sections/header'); ?>
        <script src="<?php echo base_url(); ?>media/backend/js/jquery.dataTables.min.js"></script> 
        <script src="<?php echo base_url(); ?>media/backend/js/bootstrap-tab.js"></script>
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
                    <li> <a href="<?php echo base_url(); ?>backend/dashboard">Dashboard</a> <span class="divider">/</span> </li>
                    <li>Manage Global Settings</li>
                </ul>
            </div>
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
            ?> 

            <div class="row-fluid sortable">   
                <!--[sortable header start]-->
                <div class="box span12">
                    <div class="box-header well">
                        <h2><i class=""></i>Global Settings Management</h2>
                    </div>
                    <br >
                    <!--[sortable body]-->
                    <div class="box-content">
                        <table  class="table table-striped table-bordered bootstrap-datatable datatable">
                            <thead>
                            <th width="10%" class="workcap">	
                                No
                            </th>
                            <th width="20%" class="workcap">Parameter Name</th>
                            <th width="30%" class="workcap" align="center">Parameter Value</th>
                            <th width="40%" class="workcap" align="center">Action</th>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($arr_global_settings as $key => $global_setting) {
                                    ?>
                                    <tr>
                                        <td class="worktd" align="left">
                                            <?php echo $key + 1; ?>
                                        </td>

                                        <td class="worktd"  align="left"><?php echo ucwords(str_replace("_", " ", stripslashes($global_setting['name']))); ?></td>

                                        <td class="worktd"  align="left">

                                            <?php
                                            if ($global_setting['name'] == "date_format") {
                                                echo date(stripslashes($global_setting['value']));
                                            } else {
                                                echo stripslashes($global_setting['value']);
                                            }
                                            ?>

                                        </td>

                                        <td class="worktd">

                                            <a class="btn btn-info" href="<?php echo base_url(); ?>backend/global-settings/edit/<?php echo base64_encode($global_setting['global_name_id']); ?>/<?php echo base64_encode(17); ?>" title="Edit Global Settings Parameter">
                                                <i class="icon-edit icon-white"></i>Edit</a>

                                            <a class="btn btn-primary" href="<?php echo base_url(); ?>backend/global-settings/edit-parameter-language/<?php echo base64_encode($global_setting['global_name_id']); ?>" title="Edit Global Settings Parameter for other Langauages">
                                                <i class="icon-file icon-white"></i>Multilingual</a> 

                                        </td>
                                        <?php
                                    }
                                    ?>
                            </tbody>
                        </table>
                    </div>
                    <!--[sortable body]--> 
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
