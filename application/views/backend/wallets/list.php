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
            function changeStatus(wallet_id, user_status)
            {
                /* changing the user status*/
                var obj_params = new Object();
                obj_params.wallet_id = wallet_id;
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
                            $("#blocked_div" + wallet_id).css('display', 'inline-block');
                            $("#active_div" + wallet_id).css('display', 'none');
                        }
                        else
                        {
                            $("#active_div" + wallet_id).css('display', 'inline-block');
                            $("#blocked_div" + wallet_id).css('display', 'none');
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
                    <li>Manage Bitcoin Wallet Address</li>
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
                        <h2><i class=""></i>Bitcoin Wallet Address</h2>
<!--                        <div class="box-icon">
                            <a title="Add new user" class="btn btn-plus btn-round" href="<?php echo base_url(); ?>backend/user/add"><i class="icon-plus"></i></a>
                        </div>-->
                    </div>
                    <br >
                    <form name="frm_users" id="frm_users" action="<?php echo base_url(); ?>backend/user/list" method="post">
                        <!--[sortable body]-->
                        <div class="box-content">
                            <table  class="table table-striped table-bordered bootstrap-datatable datatable">
                                <thead>
                                <th width="15%" class="workcap">Email Id</th>   
                                <th width="20%" class="workcap">Wallet GUID</th>   
                                <th width="8%" class="workcap">Created on</th>                    
                                </thead>
                                <tbody>
                                    <?php  foreach ($arr_user_wallets_list as $user_wallet) {  ?>
                                    <tr>
                                        <td class="worktd"  align="left"><a href="<?php echo base_url(); ?>backend/wallet-view/<?php echo base64_encode($user_wallet['user_id']); ?>"><?php echo ($user_wallet['wallet_email']!="")?$user_wallet['wallet_email']:"-"; ?></a></td>
                                        <td class="worktd"  align="left"><?php echo stripslashes($user_wallet['wallet_guid']); ?></td>
                                        <td class="worktd"  align="left"><?php echo date($global['date_format'], strtotime($user_wallet['created_on'])); ?></td>
                                    </tr>
                                    <?php  }  ?>
                                </tbody>
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
</div><!--/.fluid-container-->


</body>
</html>