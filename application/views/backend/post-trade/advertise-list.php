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
                    <li>Manage Advertisement List</li>
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
                        <h2><i class=""></i>List advertisement</h2>
                        <div class="box-icon"> <a title="Post trade" class="btn btn-plus btn-round" href="<?php echo base_url(); ?>backend/advertise/add"><i class="icon-plus"></i></a> </div>
                    </div>
                    <br >
                    <DataTables_Table_0_lengthform name="frm_admin_users" id="frm_admin_users" action="<?php echo base_url(); ?>backend/advertise" method="post">
                        <!--[sortable body]-->
                        <div class="box-content">
                            <table  class="table table-striped table-bordered bootstrap-datatable datatable">
                                <thead>
                                <th width="5%" class="workcap"> <?php if (count($arr_user_list) > 1) { ?>
                                    <center>
                                        Select <br>
                                        <input type="checkbox" name="check_all" id="check_all"  class="select_all_button_class" value="select all" />
                                    </center>
                                <?php } ?>
                                </th>
                                <th width="8%" class="workcap">Username</th>
                                <th width="8%" class="workcap">Geo Location</th>
                                <th width="8%" class="workcap">Payment method</th>
                                <th width="8%" class="workcap">Currency</th>
                                <th width="8%" class="workcap">Trade Type</th>
                                <th width="8%" class="workcap">Bank Service</th>
                                <th width="8%" class="workcap">Premium</th>
                                <th width="8%" class="workcap">Min Amount</th>
                                <th width="8%" class="workcap">Max Amount</th>
                                <th width="8%" class="workcap">Created on</th>
                                <th width="8%" class="workcap">Action</th>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($arr_user_list as $admin) {
                                        if ($admin['status'] == 'A') {
                                            $status = 'Active';
                                        } else {
                                            $status = 'Inactive';
                                        }
                                        ?>
                                        <tr>
                                            <td class="worktd" align="left">
                                                <?php if ($admin['role_id'] != 1) { ?>
                                        <center>
                                            <input name="checkbox[]" class="case" type="checkbox" id="checkbox[]" value="<?php echo $admin['trade_id']; ?>" />
                                        </center>
                                    <?php } ?>
                                    </td>
                                    <?php
                                    if ($admin['trade_type'] == 'sell_o') {
                                        $trade_type = 'Sell bitcoins online';
                                    } elseif ($admin['trade_type'] == 'buy_o') {
                                        $trade_type = 'Buy bitcoins online';
                                    } elseif ($admin['trade_type'] == 'sell_c') {
                                        $trade_type = 'Sell bitcoins locally for cash';
                                    } elseif ($admin['trade_type'] == 'buy_c') {
                                        $trade_type = 'Buy bitcoins locally with cash';
                                    }

                                    $admin['bank_service'] = ($admin['bank_service'] != '') ? $admin['bank_service'] : '---';
                                    $admin['city'] = ($admin['city'] != '') ? $admin['city'] : '---';
                                    ?>
                                    <td class="worktd"  align="left"><?php echo stripslashes($admin['user_name']); ?></td>
                                    <td class="worktd"  align="left"><?php echo stripslashes($admin['city']); ?></td>
                                    <td class="worktd"  align="left"><?php echo stripslashes($admin['method_name']); ?></td>
                                    <td class="worktd"  align="left"><?php echo stripslashes($admin['currency_name']); ?></td>
                                    <td class="worktd"  align="left"><?php echo stripslashes($trade_type); ?></td>
                                    <td class="worktd"  align="left"><?php echo stripslashes($admin['bank_service']); ?></td>
                                    <td class="worktd"  align="left"><?php echo stripslashes($admin['premium']); ?></td>
                                    <td class="worktd"  align="left"><?php echo stripslashes($admin['min_amount']); ?></td>
                                    <td class="worktd"  align="left"><?php echo stripslashes($admin['max_amount']); ?></td>
                                    <td class="worktd"  align="left"><?php echo stripslashes($admin['created_on']); ?></td>
                                    <td class="worktd">
                                        <a class="btn btn-info" title="Edit Advertise Details" href="<?php echo base_url(); ?>backend/advertise/edit/<?php echo base64_encode($admin['trade_id']); ?>">
                                            <i class="icon-edit icon-white"></i>Edit</a>
                                    </td>
                                    </tr>
                                <?php } ?>
                                </tbody>

                                <?php if (count($arr_user_list) > 1) { ?>
                                    <tfoot>
                                    <th colspan="12"><input type="submit" id="btn_delete_all" name="btn_delete_all" class="btn btn-danger" onClick="return deleteConfirm();"  value="Delete Selected"></th>
                                    </tfoot>
                                <?php } ?>
                            </table>
                        </div>
                        <!--[sortable body]-->
                    </form>
                </div>
            </div>
            <!--[sortable table end]-->
            <!--[include footer]-->
        </div>
        <!--/#content.span10-->
    </div>
    <!--/fluid-row-->
    <?php $this->load->view('backend/sections/footer.php'); ?>
</div>
<!--/.fluid-container-->
<script>
    function changeStatus(user_id,user_status)
    {	
        /* changing the user status*/
        var obj_params=new Object();
        obj_params.user_id=user_id;
        obj_params.user_status=user_status;
        jQuery.post("<?php echo base_url(); ?>backend/admin/change-status",obj_params,function(msg){
            if(msg.error=="1")
            {
                alert(msg.error_message);
            }
            else
            {
                /* toogling the bloked and active div of user*/
                if(user_status==2)
                {
                    $("#blocked_div"+user_id).css('display','inline-block');
                    $("#active_div"+user_id).css('display','none');
                }
                else
                {
                    $("#active_div"+user_id).css('display','inline-block');
                    $("#blocked_div"+user_id).css('display','none');
                }
            }
        },"json");
    }	
</script>
</body>
</html>