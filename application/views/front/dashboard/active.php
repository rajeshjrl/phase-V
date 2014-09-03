<div class="page_holder">
    <div class="page_inner">
        <div class="page_head">
            <h2><?php echo lang('dashboard'); ?></h2><br>
            <h6 style="font-size: 14px;margin-top: 5px;"><?php echo lang('in_these_pages_you_can_view_and_manage_your_current_advertisements_and_contacts'); ?>.</h6>

            <div class="dashbord_nav">
                <ul>
                    <li id="tab_dashboard_contacts"><a href="<?php echo base_url(); ?>user-dashboard"><?php echo lang('dashboard'); ?></a></li>
					<li class="active" id="tab_active_contacts"><a href="<?php echo base_url(); ?>ads/active"><?php echo lang('active_contacts'); ?></a></li>
                    <li id="tab_closed_contacts"><a href="<?php echo base_url(); ?>ads/closed"><?php echo lang('closed_contacts'); ?></a></li>
                    <li id="tab_released_cotacts"><a href="<?php echo base_url(); ?>ads/released"><?php echo lang('released_contacts'); ?></a></li>
                    <li id="tab_cancelled_contacts"><a href="<?php echo base_url(); ?>ads/canceled"><?php echo lang('cancelled_contacts'); ?></a></li>
                </ul>
            </div>
        </div>

        <div class="wrapper" id="closed_contacts">
            <div class="page_head">
                <h5><?php echo lang('active_contacts'); ?></h5>
            </div>
            <div class="user_advertisement">
                <table>
                    <tbody>
                        <tr class="head">
                            <th>#</th>
                            <th><?php echo lang('created_at'); ?></th>
                            <th><?php echo lang('deal'); ?></th>
                            <th><?php echo lang('transaction_status'); ?></th>
                            <!--<th><?php echo lang('change_transaction_status'); ?></th>-->
                            <th><?php echo lang('fiat'); ?></th>
                            <th><?php echo lang('btc_amount'); ?></th>                            
                            <th><?php echo lang('exchange_rate'); ?></th>
                        </tr>
                        <?php
                        if (count($arr_trade_status_list) > 0) {
                            $i = 1;
                            foreach ($arr_trade_status_list as $arr_trade) {
								
								/* Calculate fee amoun and btc amount */								
								if($user_session['user_id'] == $arr_trade['user_id'])
								{
									$fee_amount = ($global['admin_fee_percent']/100)*$arr_trade['btc_amount'];									
								}
								else
								{
									$fee_amount = 0.00;
								}							
								
								/* Calculate btc amount */
								if($user_session['user_id'] == $arr_trade['buyer_id'])
								{
									$btc_amount = $arr_trade['btc_amount'];
									$final_amount = $btc_amount - $fee_amount;
								}
								else
								{
									$btc_amount = $arr_trade['btc_amount'];
									$final_amount = $btc_amount + $fee_amount;
								}								
								
                                if (($user_session['user_id'] == $arr_trade['buyer_id']) || ($user_session['user_id'] == $arr_trade['seller_id'])) {

                                    if ($user_session['user_id'] == $arr_trade['seller_id']) {
                                        $deal = '<a href="' . base_url() . 'profile/' . $arr_trade['buyer'] . '">' . $arr_trade['buyer'] . '</a>' . ' is buying';
                                    } elseif ($user_session['user_id'] == $arr_trade['buyer_id']) {
                                        $deal = '<a href="' . base_url() . 'profile/' . $arr_trade['seller'] . '">' . $arr_trade['seller'] . '</a>' . ' is selling';
                                    }
                                    $bgcolor = ($i % 2 == 0) ? '#FDFDFF' : '#DCDCE1';
                                    ?>
                                    <tr style="background-color: <?php echo $bgcolor; ?>">
                                        <td><a href="<?php echo base_url() . 'ads/detailed-info/' . base64_encode($arr_trade['trade_id']) . '/' . base64_encode($arr_trade['transaction_id']); ?>"><?php echo $arr_trade['transaction_id']; ?></a></td>
                                        <td><?php echo date($global['date_format'], strtotime($arr_trade['created_on'])); ?></td>
                                        <td><?php echo $deal; ?></td>
                                        <td><?php
                        if (($arr_trade['transaction_status'] == 'make_payment') && ($user_session['user_id'] == $arr_trade['buyer_id'])) {
                            echo $arr_trade['transaction_status']
                                        ?>
                                                <input type="button" name="make_payment" id="make_payment" value="Pay now" onclick="javascript:window.location.href='<?php echo base_url(); ?>payment/btc-make-payment/<?php echo $arr_trade['transaction_id']; ?>'">
                                                <?php
                                            } else {
                                                echo $arr_trade['transaction_status'];
                                            }
                                            ?>
                                        </td>                                        
                                        <td><?php echo $arr_trade['fiat_currency'] . ' ' . $arr_trade['currency_code']; ?></td>
                                        <td><?php echo exp_to_dec(abs($final_amount)); ?></td>                                        
                                        <td><?php echo $arr_trade['local_currency_rate'] . ' ' . $arr_trade['currency_code']; ?></td>
                                    </tr>                                        
                                    <?php
                                    $i++;
                                }
                            }
                        } else {
                            ?>
                            <tr><td><?php echo lang('you_havent_any_advertisements'); ?>.</td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>           	
        </div>
        <?php if (count($arr_trade_status_list) > 0) { ?>
            <p><?php echo $links; ?></p>
        <?php } ?>
    </div>
	
	<p style="text-align:left; margin:40px 5px 0px 5px;">The advertiser pays the fee. In SELL advertisement the fee is added on the top of traded bitcoin amount. In BUY advertisements the fee is reduced from the traded bitcoin amount. Exchange rate is calculated on the traded amount.</p>
	
</div>
</section>
<?php 
function exp_to_dec($float_str)
{
    // make sure its a standard php float string (i.e. change 0.2e+2 to 20)
    // php will automatically format floats decimally if they are within a certain range
    $float_str = (string)((float)($float_str));

    // if there is an E in the float string
    if(($pos = strpos(strtolower($float_str), 'e')) !== false)
    {
        // get either side of the E, e.g. 1.6E+6 => exp E+6, num 1.6
        $exp = substr($float_str, $pos+1);
        $num = substr($float_str, 0, $pos);
       
        // strip off num sign, if there is one, and leave it off if its + (not required)
        if((($num_sign = $num[0]) === '+') || ($num_sign === '-')) $num = substr($num, 1);
        else $num_sign = '';
        if($num_sign === '+') $num_sign = '';
       
        // strip off exponential sign ('+' or '-' as in 'E+6') if there is one, otherwise throw error, e.g. E+6 => '+'
        if((($exp_sign = $exp[0]) === '+') || ($exp_sign === '-')) $exp = substr($exp, 1);
        else trigger_error("Could not convert exponential notation to decimal notation: invalid float string '$float_str'", E_USER_ERROR);
       
        // get the number of decimal places to the right of the decimal point (or 0 if there is no dec point), e.g., 1.6 => 1
        $right_dec_places = (($dec_pos = strpos($num, '.')) === false) ? 0 : strlen(substr($num, $dec_pos+1));
        // get the number of decimal places to the left of the decimal point (or the length of the entire num if there is no dec point), e.g. 1.6 => 1
        $left_dec_places = ($dec_pos === false) ? strlen($num) : strlen(substr($num, 0, $dec_pos));
       
        // work out number of zeros from exp, exp sign and dec places, e.g. exp 6, exp sign +, dec places 1 => num zeros 5
        if($exp_sign === '+') $num_zeros = $exp - $right_dec_places;
        else $num_zeros = $exp - $left_dec_places;
       
        // build a string with $num_zeros zeros, e.g. '0' 5 times => '00000'
        $zeros = str_pad('', $num_zeros, '0');
       
        // strip decimal from num, e.g. 1.6 => 16
        if($dec_pos !== false) $num = str_replace('.', '', $num);
       
        // if positive exponent, return like 1600000
        if($exp_sign === '+') return $num_sign.$num.$zeros;
        // if negative exponent, return like 0.0000016
        else return $num_sign.'0.'.$zeros.$num;
    }
    // otherwise, assume already in decimal notation and return
    else return $float_str;
}
?>


<script type="text/javascript">

    function changeTradeStatus(transaction_id){
    
        var transaction_status = $("#transaction_status_"+transaction_id).val();
        console.log('transaction_status =>'+transaction_status);               
        console.log('transaction_id =>'+transaction_id);               
        $.ajax({
            url : javascript_site_path+'dashboard/change-trade-request-status',
            data:{'transaction_status':transaction_status,'transaction_id':transaction_id},
            type:'post',
            success:function(response){
                console.log('response =>'+response);               
                alert("Status changed successfully.");
                location.reload();
                
            }
            
        });
           
    }
</script>
