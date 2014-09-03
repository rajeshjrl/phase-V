<?php if (!isset($flagBasicInfo)) { ?>
    <div class="tabs_slide">
        <a class="toggle" href="<?php echo base_url(); ?>profile/edit"><span>&nbsp;</span><?php echo lang(''); ?>Basic user information</a>
    </div>
<?php } ?>
<?php if (!isset($flagChangePass)) { ?>
    <div class="tabs_slide">
        <a class="toggle" href="<?php echo base_url(); ?>profile/account-setting"><span>&nbsp;</span><?php echo lang('change_passsword'); ?></a>
    </div>
<?php } ?>
<?php if (!isset($flagChangeEmail)) { ?>
    <div class="tabs_slide">
        <a class="toggle" href="<?php echo base_url(); ?>profile/change-email"><span>&nbsp;</span><?php echo lang('change_email'); ?></a>
    </div>
<?php } ?>
<?php if (!isset($flagChangeRealName)) { ?>
    <div class="tabs_slide">
        <a class="toggle" href="<?php echo base_url(); ?>profile/change-real-name"><span>&nbsp;</span><?php echo lang('real_name'); ?></a>
    </div>
<?php } ?>
<?php if (!isset($flagLocalbitcoinApps)) { ?>
    <div class="tabs_slide">
        <a class="toggle" href="<?php echo base_url(); ?>apps"><span>&nbsp;</span><?php echo lang('localbitcoin_apps'); ?></a>
    </div>
<?php } ?>
<?php if (!isset($flagAccountDeletion)) { ?>
    <div class="tabs_slide">
        <a class="toggle" href="<?php echo base_url(); ?>profile/delete"><span>&nbsp;</span><?php echo lang('account_deletion'); ?></a>
    </div>
<?php } ?>
<?php if (!isset($flagPSreceipts)) { ?>
    <div class="tabs_slide">
        <a class="toggle" href="javascript:void(0);"><span>&nbsp;</span><?php echo lang('premium_service_receipts'); ?></a>
    </div>
<?php } ?>
