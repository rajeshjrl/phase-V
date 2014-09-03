<div class="page_holder">
    <div class="page_inner">
        <div class="page_head">
            <h2><?php echo lang('dashboard'); ?></h2><br>
            <h6 style="font-size: 14px;margin:10px 0;"><?php echo lang('in_these_pages_you_can_view_and_manage_your_current_advertisements_and_contacts'); ?>.</h6>
            <div class="dashbord_nav">
                <ul>
                    <li class="active" id="tab_active_contacts"><a href="<?php echo base_url(); ?>user-dashboard"><?php echo lang('dashboard'); ?></a></li>
					<li id="tab_active_contacts"><a href="<?php echo base_url(); ?>ads/active"><?php echo lang('active_contacts'); ?></a></li>
                    <li id="tab_closed_contacts"><a href="<?php echo base_url(); ?>ads/closed"><?php echo lang('closed_contacts'); ?></a></li>
                    <li id="tab_released_cotacts"><a href="<?php echo base_url(); ?>ads/released"><?php echo lang('released_contacts'); ?></a></li>
                    <li id="tab_cancelled_contacts"><a href="<?php echo base_url(); ?>ads/canceled"><?php echo lang('cancelled_contacts'); ?></a></li>
                </ul>
            </div>
        </div>
        <div class="wrapper" id="active_contacts">
            <div class="page_head">
                <h5><?php echo lang('your_advertisements'); ?></h5>
            </div>
            <div class="user_advertisement">
                <table>
                    <tbody>
                        <tr class="head">
                            <th>#</th>
                            <th><?php echo lang('status'); ?></th>
                            <th width="30%"><?php echo lang('info'); ?></th>
                            <th width="15%"><?php echo lang('price'); ?></th>
                            <th><?php echo lang('equation'); ?></th>
                            <th><?php echo lang('created_at'); ?></th>
                            <th><?php echo lang('action'); ?></th>
                        </tr>
                        <?php
                        if (count($arr_trade_list) > 0) {
                            $i = 1;
                            foreach ($arr_trade_list as $arr_trade) {
                                //print_r($arr_trade);
                                $bgcolor = ($i % 2 == 0) ? '#FDFDFF' : '#DCDCE1';
                                $status = ($arr_trade['status'] == 'A') ? 'Active' : 'Disabled';
                                $link_color = ($arr_trade['status'] == 'A') ? 'style="color: green;"' : 'style="color: red;"';
                                ?>
                                <tr style="background-color: <?php echo $bgcolor; ?>">
                                    <td><a href="<?php echo base_url(); ?>buy-sell-bitcoin/<?php echo $arr_trade['trade_id']; ?>"><?php echo $arr_trade['trade_id'] . '<b>.</b>'; ?></a></td>
                                    <td><a <?php echo $link_color; ?> href="javascript:void(0);" onClick="changeStatus(<?php echo $arr_trade['trade_id']; ?>,'<?php echo $arr_trade['status']; ?>')"><?php echo $status; ?></a></td>
                                    <td><?php echo $arr_trade['location']; ?></td>
                                    <td><?php if($arr_trade['local_currency_rate'] != '') { echo $arr_trade['local_currency_rate'] . '-' . $arr_trade['local_currency_code']; } ?></span></td>
                                    <td><?php echo $arr_trade['price_eq']; ?></td>
                                    <td>
                                        <?php
                                        echo date($global['date_format'], strtotime($arr_trade['created_on']));
                                        ?>
                                    </td>
                                    <td class="button_buy"><a class="actedit" href="<?php echo base_url(); ?>advertise-edit/<?php echo base64_encode($arr_trade['trade_id']) ?>"><span>&nbsp;</span>Edit</a></td>
                                </tr>                                        
                                <?php
                                $i++;
                            }
                        } else {
                            ?><tr><td><?php echo lang('you_havent_any_advertisements'); ?>.</td></tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="bitadvertise">
                    <a class="bitbuyadd" href="<?php echo base_url(); ?>advertise"><span>&nbsp;</span><?php echo lang(''); ?>Create advertisement</a>
                </div>
            </div>           	
        </div>
        <p><?php echo $links; ?></p>
    </div>
</div>
</section>

<script type="text/javascript">
    function changeStatus(trade_id,status){                
        $.ajax({            
            method:'post',
            url:javascript_site_path+'ajax-change-status',
            data:{'trade_id':trade_id,'status':status},            
            success:function(response){ location.reload();}            
        });        
    }
</script>
