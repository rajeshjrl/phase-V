<?php
//echo 'here';
//exit;
?>
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
                    <li>trade request list</li>
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
                        <h2><i class=""></i>trade request list</h2>
                        <div class="box-icon"> </div>
                    </div>
                    <br >
                    <form name="frm_admin_users" id="frm_admin_users" action="<?php echo base_url(); ?>backend/advertise/trade-requests-list" method="post">
                        <!--[sortable body]-->
                        <div class="box-content">
                            <table  class="table table-striped table-bordered bootstrap-datatable datatable">
                                <thead>
                                <th width="5%" class="workcap"> <?php if (count($arr_trade_request_details) > 1) { ?>
                                    <center>
                                        Select <br>
                                        <input type="checkbox" name="check_all" id="check_all"  class="select_all_button_class" value="select all" />
                                    </center>
                                <?php } ?>
                                </th>
                                <th width="8%" class="workcap">Transaction ID</th>
                                <th width="8%" class="workcap">Created at</th>
                                <th width="8%" class="workcap">Buyer</th>
                                <!--<th width="8%" class="workcap"></th>-->
                                <th width="8%" class="workcap">Transaction status</th>
                                <th width="8%" class="workcap">Fiat</th>
                                <th width="8%" class="workcap">Transaction type</th>
                                <th width="8%" class="workcap">BTC amount</th>
                                <!--<th width="8%" class="workcap">Fee</th>-->
                                <th width="8%" class="workcap">Exchange rate</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($arr_trade_request_details as $trade_request_details) { ?>
                                        <tr>
                                            <td class="worktd" align="left">
                                                <?php if ($trade_request_details['role_id'] != 1) { ?>
                                        <center><input name="checkbox[]" class="case" type="checkbox" id="checkbox[]" value="<?php echo $trade_request_details['transaction_id']; ?>" /></center>
                                    <?php } ?>
                                    </td>
                                    <?php
                                    if ($trade_request_details['trade_type'] == 'sell_o') {
                                        $trade_type = 'Sell bitcoins online';
                                    } elseif ($trade_request_details['trade_type'] == 'buy_o') {
                                        $trade_type = 'Buy bitcoins online';
                                    } elseif ($trade_request_details['trade_type'] == 'sell_c') {
                                        $trade_type = 'Sell bitcoins locally for cash';
                                    } elseif ($trade_request_details['trade_type'] == 'buy_c') {
                                        $trade_type = 'Buy bitcoins locally with cash';
                                    }
                                    ?>
                                    <td class="worktd"  align="left"><?php echo '#' . stripslashes($trade_request_details['transaction_id']); ?></td>
                                    <td class="worktd"  align="left"><?php echo stripslashes($trade_request_details['created_on']); ?></td>
                                    <td class="worktd"  align="left"><?php echo stripslashes($trade_request_details['user_name']); ?></td>
                                    <td class="worktd"  align="left">
                                        <select name="transaction_status" id="transaction_status"   onchange="changeStatus(<?php echo $trade_request_details['transaction_id']; ?>,this.value)" style="width: 95%;border-radius: 6px 6px 6px;" title="change status">
                                            <option  <?php echo (trim($trade_request_details['transaction_status']) == 'closed') ? "selected='selected'" : ''; ?> value="closed">closed</option>
                                            <option  <?php echo (trim($trade_request_details['transaction_status']) == 'cancelled') ? "selected='selected'" : ''; ?> value="cancelled">cancelled</option>
                                            <option  <?php echo (trim($trade_request_details['transaction_status']) == 'released') ? "selected='selected'" : ''; ?> value="released">released</option>
                                            <option  <?php echo (trim($trade_request_details['transaction_status']) == 'pending') ? "selected='selected'" : ''; ?>value="pending">pending</option>
                                        </select>
                                    </td>
                                    <td class="worktd"  align="left"><?php echo stripslashes($trade_request_details['fiat_currency']); ?>   <b><?php echo stripslashes($trade_request_details['currency_code']); ?></b></td>
                                    <td class="worktd"  align="left"><?php echo stripslashes($trade_type); ?></td>
                                    <td class="worktd"  align="left"><?php echo stripslashes($trade_request_details['btc_amount']); ?></td>
                                    <!--<td class="worktd"  align="left"><?php echo stripslashes($trade_type); ?></td>-->
                                    <td class="worktd"  align="left"><?php echo stripslashes($trade_request_details['local_currency_rate']); ?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>

                                <?php if (count($arr_trade_request_details) > 1) { ?>
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

    /* change the status of trade request*/
    
    function changeStatus(transaction_id,status){  
              
        $.ajax({            
            method:'post',
            url:'<?php echo base_url(); ?>backend/advertise/ajax-change-trade-status',
            data:{'transaction_id':transaction_id,'status':status},            
            success:function(response){ alert('trade status changed successfully.'); }            
        });        
    }
</script>
</body>
</html>
