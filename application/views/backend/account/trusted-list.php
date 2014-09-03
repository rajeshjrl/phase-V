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
                    <li>Manage Trusted People</li>
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
                        <h2><i class=""></i>Trusted people managment</h2>
                    </div>
                    <br >
                    <form name="frm_admin_users" id="frm_admin_users" action="<?php echo base_url(); ?>backend/accounts/trusted" method="post">
                        <!--[sortable body]-->
                        <div class="box-content">
                            <table  class="table table-striped table-bordered bootstrap-datatable datatable">
                                <thead>
                                
                                <th width="8%" class="workcap">Username</th>
                                <th width="8%" class="workcap">Trust on</th>
								<th width="8%" class="workcap">Feedback Status</th>
								<th width="8%" class="workcap">Updated on</th>
								
                                
                                </thead>
                                <tbody>
                                <?php foreach ($arr_user_list as $admin) {  
								
									if($admin['status']=='T'){$status='Trustworthy';}
									elseif($admin['status']=='P'){$status='Positive';}
									elseif($admin['status']=='N'){$status='Neutral';}
									elseif($admin['status']=='D'){$status='Distrust and block';}
									elseif($admin['status']=='B'){$status='Block without feedback';}?>
								
                                 	<tr>
                                    <td class="worktd"  align="left"><?php echo stripslashes($admin['user_name']); ?></td>
									<?php if($admin['invitation_to']=='NULL') {?>
									<td class="worktd"  align="left"><?php echo stripslashes($admin['friend_email']); ?></td>
									<?php } else { ?>
									<td class="worktd"  align="left"><?php echo stripslashes($admin['trusted_on']); ?></td>
									<?php } ?>
									<td class="worktd"  align="left"><?php echo stripslashes($status); ?></td>
									<td class="worktd"  align="left"><?php echo stripslashes($admin['updated_on']); ?></td>
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