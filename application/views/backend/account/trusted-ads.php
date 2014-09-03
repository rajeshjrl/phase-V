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
                    <li>Trusted advertisements</li>
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
            ?>  
            <div class="row-fluid sortable">  
                <!--[sortable header start]-->
                <div class="box span12">
                    <div class="box-header well">
                        <h2><i class=""></i>Trusted advertisements</h2>
                    </div>
                    <br >
                    <form name="frm_admin_users" id="frm_admin_users" action="<?php echo base_url(); ?>backend/accounts/trusted" method="post">
                        <!--[sortable body]-->
                        <div class="box-content">
                            <table  class="table table-striped table-bordered bootstrap-datatable datatable">
                                <thead>                                
									<th width="8%" class="workcap">Trade Id</th>
									<th width="8%" class="workcap">Username</th>
									<th width="8%" class="workcap">Trade Type</th>
									<th width="8%" class="workcap">Amount</th>
									<th width="8%" class="workcap">Location</th>
									<th width="8%" class="workcap">Created On</th>								
                                </thead>
                                <tbody>
                                <?php foreach ($arr_trusted_advertise_list as $trade) {
									
									if($trade['trade_type']=='buy_o'){$trade_type='Buy Online';}
									elseif($trade['trade_type']=='sell_o'){$trade_type='Sell Online';}
									elseif($trade['trade_type']=='buy_c'){$trade_type='Buy Cash';}
									elseif($trade['trade_type']=='sell_c'){$trade_type='Sell Cash';}
								?>								
                                 	<tr>
                                    <td class="worktd"  align="left"><?php echo stripslashes($trade['trade_id']); ?></td>									
									<td class="worktd"  align="left"><?php echo stripslashes($trade['user_name']); ?></td>									
									<td class="worktd"  align="left"><?php echo stripslashes($trade_type); ?></td>									
									<td class="worktd"  align="left"><?php echo stripslashes($trade['min_amount'].'-'.$trade['max_amount'].' '.$trade['currency_code']); ?></td>
									<td class="worktd"  align="left"><?php echo stripslashes($trade['location']); ?></td>
									<td class="worktd"  align="left"><?php echo stripslashes($trade['created_on']); ?></td>
									</tr>                                    
                                <?php } ?>
                                </tbody>
                                
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