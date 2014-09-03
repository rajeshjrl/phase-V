<section id="content" class="cms dashboard invite_friends">
    <div class="user_dash">
        <div class="page_holder">
            <div class="page_inner">
                <div class="user_navi">
                    <ul>
                        <li <?php echo ($menu_active == "user-dashboard") ? 'class="active"' : ""; ?>><a href="<?php echo base_url(); ?>user-dashboard"><?php echo lang('dashboard'); ?></a><span class="arrow"></span></li>
                        <li <?php echo ($menu_active == "wallet") ? 'class="active"' : ""; ?>><a href="<?php echo base_url(); ?>wallet">Wallet:<span> <?php echo $this->session->userdata('user_wallet_balance');?> BTC</span></a><span class="arrow"></span></li>
                        <li <?php echo ($menu_active == "trusted") ? 'class="active"' : ""; ?>><a href="<?php echo base_url(); ?>trusted-contacts/invite-friend">Invite friends</a><span class="arrow"></span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>