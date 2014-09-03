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
        <script type="text/javascript">
            function changeStatus(user_id, user_status)
            {
                /* changing the user status*/
                var obj_params = new Object();
                obj_params.user_id = user_id;
                obj_params.user_status = user_status;
                jQuery.post("<?php echo base_url(); ?>backend/user/change-status", obj_params, function(msg) {
                    if (msg.error == "1")
                    {
                        alert(msg.error_message);
                    }
                    else
                    {
                        /* toogling the bloked and active div of user*/
                        if (user_status == 2)
                        {
                            $("#blocked_div" + user_id).css('display', 'inline-block');
                            $("#active_div" + user_id).css('display', 'none');
                        }
                        else
                        {
                            $("#active_div" + user_id).css('display', 'inline-block');
                            $("#blocked_div" + user_id).css('display', 'none');
                        }
                    }
                }, "json");

            }
        </script>
    </head>
    <body>
        <?php $this->load->view('backend/sections/top-nav.php'); ?>
        <?php $this->load->view('backend/sections/leftmenu.php'); ?>
        <div id="content" class="span10">
            <!--[breadcrumb]-->
            <div>
                <ul class="breadcrumb">
                    <li> <a href="<?php echo base_url(); ?>backend/dashboard">Dashboard</a> <span class="divider">/</span> </li>
                    <li>User Deletion Requests</li>
                </ul>
            </div>

            <!--[message box]-->
            <?php
            $msg = $this->session->userdata('msg');
            ?>
            <!--[message box]-->
            <?php if ($msg != '') { ?>
                <div class="msg_box alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" id="msg_close" name="msg_close">�</button>
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
                        <h2><i class=""></i>User Deletion Request</h2>
                    </div>
                    <br >
                    <form name="frm_users" id="frm_users" action="<?php echo base_url(); ?>backend/user/deletion-list" method="post">
                        <!--[sortable body]-->
                        <div class="box-content">
                            <table  class="table table-striped table-bordered bootstrap-datatable datatable">
                                <thead>
                                <th width="7%" class="workcap">
                                    <?php
                                    if (count($arr_user_list) > 1) {
                                        ?>
                                    <center>Select <br><input type="checkbox" name="check_all" id="check_all"  class="select_all_button_class" value="select all" /></center>
                                    <?php
                                }
                                ?>               
                                </th>
                                <th width="8%" class="workcap">Username</th>
                                <th width="12%" class="workcap">Real Name</th>
                                <!--<th width="12%" class="workcap">Last Name</th>-->   
                                <th width="10%" class="workcap">Requested On</th>
                                <th width="10%" class="workcap">Status</th>                    
                                <th width="15%" class="workcap" align="center">Action</th>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($arr_user_list as $user) {
                                        ?>
                                        <tr>

                                            <td class="worktd" align="left">
                                    <center><input name="checkbox[]" class="case" type="checkbox" id="checkbox[]" value="<?php echo $user['id']; ?>" /></center>

                                    </td>
                                    <td class="worktd"  align="left"><?php echo stripslashes($user['user_name']); ?></td>
                                    <td class="worktd"  align="left"><?php echo stripslashes($user['first_name']); ?></td>
                                    <!--<td class="worktd"  align="left"><?php echo stripslashes($user['last_name']); ?></td>-->
                                    <td class="worktd"  align="left"><?php echo stripslashes($user['requested_timestamp']); ?></td>                                    

                                    <td class="worktd"  align="left">

                                        <?php
                                        if ($user['role_id'] != 1) {
                                            if ($user['user_status'] == 0) {
                                                ?>
                                                <div>
                                                    <a style="cursor:default;" class="label label-warning" href="javascript:void(0);" id="status_<?php echo $user['user_id']; ?>">Inactive</a>
                                                </div>
                                                <?php
                                            } else {
                                                ?>
                                                <div id="active_div<?php echo $user['user_id']; ?>"  <?php if ($user['user_status'] == 1) { ?> style="display:inline-block" <?php } else { ?> style="display:none;" <?php } ?> >
                                                    <a class="label label-success" title="Click to Change Status" onClick="changeStatus('<?php echo $user['user_id']; ?>', 2);" href="javascript:void(0);" id="status_<?php echo $user['user_id']; ?>">Active</a>
                                                </div>

                                                <div id="blocked_div<?php echo $user['user_id']; ?>" <?php if ($user['user_status'] == 2) { ?> style="display:inline-block" <?php } else { ?> style="display:none;" <?php } ?> >
                                                    <a class="label label-important" title="Click to Change Status" onClick="changeStatus('<?php echo $user['user_id']; ?>', 1);" href="javascript:void(0);" id="status_<?php echo $user['user_id']; ?>">Blocked</a>
                                                </div>

                                                <?php
                                            }
                                            ?>

                                            <?php
                                        } else {
                                            ?>
                                            <div id="active_div">
                                                <a class="label label-success" style="cursor:default;" title="" href="javascript:void(0);" id="status">Active</a>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </td>

                                    <td class="worktd">

                                        <a class="btn btn-primary" title="View User Details" href="<?php echo base_url(); ?>backend/user/view-request/<?php echo base64_encode($user['id']); ?>">
                                            <i class="icon-edit icon-white"></i>View</a>
                                    </td>
                                    <?php
                                }
                                ?>
                                </tbody>
                                <?php
                                if (count($arr_user_list) > 1) {
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