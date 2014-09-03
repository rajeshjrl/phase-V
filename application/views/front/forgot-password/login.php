<section id="content">
    <div class="page_holder">
        <div class="page_inner">
            <div class="login_form">
                <div class="banner_right">
                    <div class="banner_form">
                        <div class="banner_form_top"></div>
                        <div class="banner_form_data">
                            <div class="formdata">
                                <div class="page_head"><h2>Login</h2></div>
                                <form id="frm_user_login" name="frm_user_login" method="post" action="<?php echo base_url(); ?>signin">                            	
                                    <fieldset>
                                        <label>Username/Email</label>
                                        <input type="text" id="user_name" name="user_name" autocomplete="off">
                                    </fieldset>
                                    <fieldset>
                                        <label>Password</label>
                                        <input type="password" name="user_password" id="user_password" autocomplete="off">                                    
                                    </fieldset>
                                    <fieldset>
                                        <a class="form_link" href="<?php echo base_url(); ?>password-recovery">Forgot password?</a>
                                    </fieldset>                               
                                    <fieldset class="button">
                                        <input type="submit" name="btn_login" id="btn_login" value="Login">
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                        <div class="banner_form_shadow"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
