<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo isset($title) ? $title : ''; ?>-Admin Panel</title>
        <?php $this->load->view('backend/sections/header.php'); ?>
        <script src="<?php echo base_url(); ?>media/backend/js/jquery.dataTables.min.js"></script> 
        <script src="<?php echo base_url(); ?>media/backend/js/bootstrap-tab.js"></script>
        <!-- library for advanced tooltip -->
        <script src="<?php echo base_url(); ?>media/backend/js/bootstrap-tooltip.js"></script>
        <script src="<?php echo base_url(); ?>media/backend/js/charisma.js"></script>
		<script type="text/javascript">
            function changeStatus(method_id, method_status)
            {
                /* changing the user status*/
                var obj_params = new Object();
                obj_params.method_id = method_id;
                obj_params.method_status = method_status;
                jQuery.post("<?php echo base_url(); ?>backend/payment-method/change-status", obj_params, function(msg) {
                    if (msg.error == "1")
                    {
                        alert(msg.error_message);
                    }
                    else
                    {
                        /* toogling the bloked and active div of user*/
                        if (method_status == 'I')
                        {
                            $("#blocked_div" + method_id).css('display', 'inline-block');
                            $("#active_div" + method_id).css('display', 'none');
                        }
                        else
                        {
                            $("#active_div" + method_id).css('display', 'inline-block');
                            $("#blocked_div" + method_id).css('display', 'none');
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
                    <li> <a href="javascript:void(0)">Dashboard</a> <span class="divider">/</span> </li>
                    <li> <a href="<?php echo base_url(); ?>backend/forum-list">Manage Payment Method List</a> </li>
                </ul>
            </div>

            <!--[message box]-->
            <?php if ($this->session->userdata('msg') != '') { ?>
                <div class="msg_box alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" id="msg_close" name="msg_close">×</button>
                    <?php echo $this->session->userdata('msg'); ?> </div>
                <?php
                $this->session->unset_userdata('msg');
            }
            ?>
            <div class="row-fluid sortable"> 
                <!--[sortable header start]-->
                <div class="box span12">
                    <div class="box-header well">
                        <h2><i class=""></i>Payment Method Management</h2>
                        <div class="box-icon">
                            <a title="Add new payment method" class="btn btn-plus btn-round" href="<?php echo base_url(); ?>backend/payment-method/add"><i class="icon-plus"></i></a>
                        </div>
                    </div                    
                    ><br >
                    <!--[sortable body]-->
                    <div class="box-content">
                        <table  class="table table-striped table-bordered bootstrap-datatable datatable">
                            <thead>
                            <th width="3%" class="workcap">#</th>
                            <th width="20%" class="workcap">Method name</th>
                            <th width="15%" class="workcap">Parent Category</th>
							<th width="15%" class="workcap">Method Url</th>
							<th width="10%" class="workcap">Risk level</th>
                            <th width="10%" class="workcap">Status</th>
                            <th width="15%" class="workcap">Created On</th>                        
                            <th width="16%" class="workcap" align="center">Action</th>
                            </thead>
                            <tbody>
                                <?php
                                $cnt = 0;
                                foreach ($arr_payment_categories_list as $payment_categories) {
                                    $cnt++;
                                    ?>
                                    <tr>
                                        <td class="worktd"  align="left"><?php echo $cnt; ?></td>
                                        <td class="worktd"  align="left"><?php echo ucfirst(strip_slashes($payment_categories['method_name'])); ?></td>
                                        <td class="worktd"  align="left"><?php echo (trim($payment_categories['parent_category']) == "") ? "-" : $payment_categories['parent_category']; ?></td>
										<td class="worktd"  align="left"><?php echo $payment_categories['method_url']; ?></td>
										<td class="worktd"  align="left"><?php echo ucfirst($payment_categories['risk_level']); ?></td>
                                        <td class="worktd"  align="left">
                                        
										<?php if($payment_categories['parent_method_id'] != '0') { ?> 											
										<div id="active_div<?php echo $payment_categories['method_id']; ?>"  <?php if ($payment_categories['status'] == 'A') { ?> style="display:inline-block" <?php } else { ?> style="display:none;" <?php } ?>>
											<a class="label label-success" title="Click to Change Status" onClick="changeStatus('<?php echo $payment_categories['method_id']; ?>', 'I');" href="javascript:void(0);" id="status_<?php echo $payment_categories['method_id']; ?>">Active</a>
										</div>
                                             
										<div id="blocked_div<?php echo $payment_categories['method_id']; ?>" <?php if ($payment_categories['status'] == 'I') { ?> style="display:inline-block" <?php } else { ?> style="display:none;" <?php } ?>>
											<a class="label label-important" title="Click to Change Status" onClick="changeStatus('<?php echo $payment_categories['method_id']; ?>', 'A');" href="javascript:void(0);" id="status_<?php echo $payment_categories['method_id']; ?>">Inactive</a>
										</div>
										
										<?php } ?>				
                                                
                                                
                                        </td>
                                        <td class="worktd"  align="left"> <?php echo date($global['date_format'], strtotime($payment_categories['created_on'])); ?></td>
                                        <td class="worktd">
											<?php if($payment_categories['parent_method_id'] != '0') { ?>
                                            <a class="btn btn-info" href="<?php echo base_url(); ?>backend/payment-method/edit/<?php echo $payment_categories['method_id']; ?>" title="Edit Payment Method"><i class="icon-edit icon-white"></i>Edit</a>
											<?php } ?>                                                        
                                        </td>
                                    <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!--[sortable body]--> 
                </div>
            </div>
            <!--[sortable table end]--> 
            <!--[include footer]-->
        </div>
    </div>
    <!--including footer here-->
    <?php $this->load->view('backend/sections/footer.php'); ?>
</div>
</body>
</html>
