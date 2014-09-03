<?php //echo "<pre>";print_r($user_session);exit;   ?>
<div class="page_holder">
    <div class="page_inner">
        <div class="user_navi">
            <ul>
                <?php if ((isset($user_session['trust'])) && (!empty($user_session['trust']))) { ?>
                                            <!--<li class="drops"><a href="javascript:void(0);">Notification<span class="arrow_profile"></span></a>
                                                    <ul class="profile_menu">
                    <?php foreach ($user_session['trust'] as $trust) { ?>
                                                                        <li><a  title="Public profile" href="<?php echo base_url(); ?>p/<?php echo $trust['user_name'] ?>" ><?php echo $trust['user_name']; ?> has invited you to LocalBitcoins</a></li>
                    <?php } ?>
                                                    </ul>
                                            </li>-->
                <?php } ?>
                <li><a href="<?php echo base_url(); ?>user-dashboard"><?php echo lang('dashboard'); ?></a><span class="arrow"></span></li>
                <li><a href="javascript:void(0);">Wallet:<span> 0 BTC</span></a><span class="arrow"></span></li>
                <li <?php echo ($menu_active == "trusted") ? 'class="active"' : ""; ?>><a href="<?php echo base_url(); ?>trusted-contacts/invite-friend">Invite friends</a><span class="arrow"></span></li>
            </ul>
        </div>
    </div>
</div>  