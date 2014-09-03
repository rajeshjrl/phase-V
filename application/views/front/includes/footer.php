<footer id="footer">
    <?php
    /* include footer1 for index-page only */
    if ((isset($indexFlag)) && ($indexFlag != '')) {
        include 'marcket-place-footer.php';
    }
    ?>
    <div class="page_holder">
        <div class="page_inner">
            <div class="company_footer">
                <div class="logo_link">
                    <a href="<?php echo base_url(); ?>"><span>&nbsp;</span>Cryptosi.com</a>
                </div>
                <div class="footer_nav">
                    <ul>
                        <?php if ((isset($user_session['user_id'])) && (!empty($user_session['user_id']))) { ?>
                            <li><a href="<?php echo base_url(); ?>wallet"><?php echo lang('wallet'); ?></a></li><span>|</span>
                            <li><a href="<?php echo base_url(); ?>profile/<?php echo $user_session['user_name']?>"><?php echo lang('profile'); ?></a><a href="<?php echo base_url(); ?>profile/edit">(<?php echo lang('edit'); ?>)</a></li><span>|</span>
                            <li><a href="<?php echo base_url(); ?>profile/account-setting"><?php echo lang('change_password'); ?></a></li><span>|</span>
                            <li><a href="<?php echo base_url(); ?>user-dashboard"><?php echo lang('dashboard'); ?> </a></li><span>|</span>
                            <li><a href="<?php echo base_url(); ?>apps"><?php echo lang('apps'); ?></a></li><span>|</span>
                            <li><a href="<?php echo base_url(); ?>cms/17/fees"><?php echo lang('fees_and_charges'); ?></a></li><span>|</span>
                            <li><a href="<?php echo base_url(); ?>cms/17/terms-services"><?php echo lang('terms_of_service'); ?></a></li><span>|</span>
                            <li><a href="<?php echo base_url(); ?>cms/17/privacy-policy"><?php echo lang('privacy_policy'); ?></a></li>
                        <?php } else { ?>
                            <li><a href="<?php echo base_url(); ?>signin"><?php echo lang('login'); ?></a></li><span>|</span>
                            <li><a href="<?php echo base_url(); ?>signup"><?php echo lang('sign_up'); ?></a></li><span>|</span>
                            <li><a href="<?php echo base_url(); ?>cms/17/fees"><?php echo lang('fees_and_charges'); ?></a></li><span>|</span>
                            <li><a href="<?php echo base_url(); ?>cms/17/terms-services"><?php echo lang('terms_of_service'); ?></a></li><span>|</span>
                            <li><a href="<?php echo base_url(); ?>cms/17/privacy-policy"><?php echo lang('privacy_policy'); ?></a></li><span>|</span>
                            <li><a href="<?php echo base_url(); ?>cms/17/faq"><?php echo lang('faqs'); ?></a>
                            <?php } ?>
                    </ul>
                </div>
                <div class="social_media">
                    <div class="social_links">
                        <ul>
                            <li><a class="chat" href="<?php echo base_url(); ?>chat"><span>&nbsp;</span>Chat</a></li>
                            <li><a class="facebook" href="<?php echo $global['facebook_link']; ?>" target="_blank"><span>&nbsp;</span>Facebook</a></li>
                            <li><a class="twitter" href="<?php echo $global['twiter_link']; ?>" target="_blank"><span>&nbsp;</span>Twitter</a></li>
                            <li><a class="google_plus" href="<?php echo $global['google_plus_link']; ?>" target="_blank"><span>&nbsp;</span>Google plus</a></li>
                            <li><a class="blog" href="<?php echo $global['blog_link']; ?>" target="_blank"><span>&nbsp;</span>Blog</a></li>
                        </ul>
                        <div class="copyright_sect">&copy;2014 <a href="<?php echo base_url(); ?>">Cryptosi.com</a> <?php echo lang('all_rights_reserved'); ?>.</div>
                    </div>
                    <div class="copyright_sect"><?php echo lang('feedback_and_questions_are_very_welcome_to'); ?><br/><a href="<?php echo base_url() ?>support-and-contact"><?php echo lang('our_support_and_contact_form'); ?></a></div>
                </div>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
<!--<script type="text/javascript">
    
    window.addEventListener("beforeunload", function(e){
        // Do something
        alert('sandeep');
    }
</script>-->
