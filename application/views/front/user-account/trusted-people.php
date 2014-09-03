<script type="text/javascript">

    $(document).ready(function(e){        
        jQuery("#frm_invite_frnd").validate({     
            errorClass: "text-danger",               
            rules:{                
                friends_email:{
                    required:true,
                    email:true
                },                
                friends_name:{
                    required:true
                }                
            },
            messages:{
                friends_email:{
                    required:"Please enter your friends email address.",
                    email:"Please enter valid email address."
                },                   
                friends_name:{
                    required:"Please enter your friends name."
                }                   
            }        
        });
    });
</script>

<div class="page_holder">
    <div class="page_inner">
        <div class="page_head">
            <h2><?php echo lang('trusted_people'); ?></h2>
            <div class="dashbord_nav">
                <ul>
                    <li <?php echo ($menu_active == "trusted") ? 'class="active"' : ""; ?>><a href="<?php echo base_url(); ?>trusted-contacts/invite-friend"><?php echo lang('your_trusted_people'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>trusted-bitcoins"><?php echo lang('send_from_wallet'); ?><?php echo lang('your_trusted_advertisements'); ?></a></li>
                    <li><a href="<?php echo base_url(); ?>cms/17/faq"><?php echo lang('send_from_wallet'); ?><?php echo lang('more_about_the_trust_system'); ?> </a></li>
                </ul>
            </div>
        </div>
        <div class="wallet_section">
            <div class="send_bitcoin">
                <div class="send_bitcoin_in invite_friend_in">
                    <div class="page_head">
                        <h5><?php echo lang('special_deals_for_trusted_people'); ?></h5>
                    </div>
                    <div class="info_send">
                        <p>Trusted people can access your advertisements marked as trusted. You can <a href="<?php echo base_url(); ?>advertise">create special advertisements</a> for friends with better price and less limitations with Trusted people only option.</p>
                        <p>Invite friends to myBitcoins, give trusted feedback after trade or visit the user profile to make people trusted.</p>
                        <p>Only trusted people can access your trusted advertisements.</p>
                    </div>
                </div>                	
            </div>
            <div class="send_bitcoin right">
                <div class="send_bitcoin_in invite_friend_in">
                    <div class="page_head">
                        <h5><?php echo lang('invite_friends_to'); ?> Cryptosi.com</h5>
                    </div>
                    <div class="info_send">
                        <span><?php echo lang('invited_friends_gain_access_your_trusted_advertisements'); ?>.</span>                        	
                    </div>
                    <div class="banner_form_data">
                        <div class="formdata">                        	
                            <form id="frm_invite_frnd" name="frm_invite_frnd" method="post" action="<?php echo base_url(); ?>trusted-contacts/invite-friend">
                                <fieldset>
                                    <label><?php echo lang('your_name'); ?></label>
                                    <input type="text" id="user_name"  readonly="readonly" name="user_name" value="<?php echo $arr_user_data['user_name']; ?>">
                                </fieldset>
                                <fieldset>
                                    <label><?php echo lang('friends_name'); ?></label>
                                    <input type="text" name="friends_email" id="friends_email">
                                </fieldset>
                                <fieldset>
                                    <label><?php echo lang('friends_email'); ?></label>
                                    <input type="text" name="friends_name" id="friends_name">                                   
                                </fieldset>
                                <fieldset class="button">
                                    <button type="submit" name="btn_invite" id="btn_invite" value="1"><span>&nbsp;</span><?php echo lang('send_invitaion_email'); ?></button>
                                </fieldset>
                            </form>
                        </div>
                    </div>                    
                </div>                	
            </div>                
        </div>
        <div class="wrapper">
            <div class="page_head">
                <h5><?php echo lang('people_you_trust'); ?></h5>
            </div>
            <div class="user_advertisement">
                <table>
                    <tbody>
                        <tr class="head">
                            <th><?php echo lang('profile'); ?></th>
                            <th class="confirm_colum"><?php echo lang('has_trade'); ?></th>                                
                        </tr>
                        <?php if (count($arr_people_you_trust_list) > 0) { ?>
                            <?php foreach ($arr_people_you_trust_list as $you_trust) { ?>
                                <tr>
                                    <td><a href="<?php echo base_url(); ?>profile/<?php echo $you_trust['user_name']; ?>"><?php echo $you_trust['user_name']; ?>(<?php echo $you_trust['confirmed_trade_count']; ?>)</a></td>
                                    <td><?php echo lang('no'); ?></td>                                
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td><?php echo lang('currently_you_have_no_trusted_people'); ?></td>
                            </tr>
                        <?php } ?>                           
                    </tbody>
                </table>                   
            </div>
            <div class="page_head">
                <h5><?php echo lang('people_that_trust_you'); ?></h5>
            </div>
            <div class="user_advertisement">
                <table>
                    <tbody>
                        <tr class="head">
                            <th><?php echo lang('profile'); ?></th>
                            <th class="confirm_colum"><?php echo lang('has_trade'); ?></th>                                
                        </tr>
                        <?php if (count($arr_people_trust_you_list) > 0) { ?>
                            <?php foreach ($arr_people_trust_you_list as $trust_you) { ?>
                                <tr>
                                    <td><a href="<?php echo base_url(); ?>profile/<?php echo $trust_you['user_name']; ?>"><?php echo $trust_you['user_name']; ?>(<?php echo $trust_you['confirmed_trade_count']; ?>)</a></td>
                                    <td><?php echo lang('no'); ?></td>                                
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td><?php echo lang('currently_no_people_trust_you'); ?></td>
                            </tr>
                        <?php } ?>          
                        <tr class="total_show">
                            <td><p><strong><?php echo lang('trades_with_people_who_trust_you_total'); ?></strong><br>
                                    <?php echo lang('this_number_is_shown_on_your'); ?> <a href="<?php echo base_url(); ?>profile"><?php echo lang('public_profile'); ?>.</a></p></td>
                            <td>0</td>
                        </tr>                            
                    </tbody>
                </table>                   
            </div>            	
        </div>
    </div>
</div>
</section>