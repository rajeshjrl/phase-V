<section id="content" class="cms dashboard">
    <div class="page_holder">
        <div class="page_inner">
            <div class="cms_text change_forum">
                <div class="change_profile_image">
                    <p><?php echo lang('your_current_avatar_image'); ?>:</p>
                    <?php if ($profile_image['profile_picture'] != '') { ?>
                        <img src="<?php echo base_url(); ?>media/front/images/profile-images/thumb/<?php echo $profile_image['profile_picture']; ?>" >
                    <?php } else { ?>
                        <img src="<?php echo base_url(); ?>media/front/images/photo-45519.gif" width="142" height="142">
                    <?php } ?>
                </div>
                <div class="page_head">
                    <h2><?php echo lang('upload_new_avatar_image'); ?></h2>
                </div>
                <div class="wrapper">
                    <p><?php echo lang('choose_image_file_from_your_computer'); ?></p>

                    <form name="frm_upload_avatar_img" id="frm_upload_avatar_img" enctype="multipart/form-data" action="<?php echo base_url(); ?>forum/change" method="post"> 
                        <input type="file" name="new_avatar_img" id="new_avatar_img" ><br><br>
                        <fieldset class="button">
                            <button type="submit" name="btn_upload" id="btn_upload" value="btn_upload"><?php echo lang('upload_new_image'); ?></button>
                        </fieldset>
                        <input type="hidden" name="old_avatar_img" id="old_avatar_img" value="<?php echo $profile_image['profile_picture']; ?>">
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>