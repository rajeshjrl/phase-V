<script type="text/javascript">

</script>

<style type="text/css">
    div.error { /* the .error class is automatically assigned by the plug-in */
        font-size: 15px;
        width: 288px;
        color: red;    
    }
</style>
<section id="content" class="cms contact post_trade">
    <div class="page_holder">
        <div class="page_inner">
            <div class="cms_text">
                <div class="page_head">
                    <h2>Contact Us</h2>
                </div>
                <div class="wrapper">
                    <div class="banner_form_data send_bitcoin_in">
                        <div class="formdata">
                            <form id="contact_us_frm" name="contact_us_frm" action="<?php echo base_url(); ?>contact-us" method="post" enctype="multipart/form-data" style="display: block; ">
                                <input type="hidden" name="user_id" value="<?php echo $this->session->userdata('user_id'); ?>">
                                <fieldset>
                                    <?php if ($user_session['user_id'] == '') { ?>
                                        <label>Reply address <font>*</font></label>
                                        <div class="tex_data">
                                            <input type="text" name="reply_email" id="reply_email">
                                        </div>
                                    <?php } ?>
                                </fieldset>
                                <fieldset>
                                    <label>Write Message <font>*</font></label>
                                    <div class="tex_data">
                                        <textarea cols="40" rows="10" name="message" id="message"></textarea>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <label>Attachment (optional)</label>
                                    <div class="tex_data">
                                        <input type="file" name="attachment" id="attachment" />
                                        <label>(Upload a related image e.g. a screenshot.) </label>
                                    </div>
                                </fieldset>
                                <fieldset class="button">
                                    <label>&nbsp;</label>
                                    <input type="submit" name="send_request" id="send_request" value="Send Request" />
                                </fieldset>
                            </form>
                        </div>
                    </div>                   



                </div>
            </div>
        </div>
    </div>
</section>