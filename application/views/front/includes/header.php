<!DOCTYPE>
<html>
    <head>
        <link rel="icon"  type="image/png" href="<?php echo base_url(); ?>media/front/images/Bitcoin-Red.png"></link>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Bootbusiness | Short description about company">
        <meta name="author" content="dev25" >
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
        <meta name="apple-mobile-web-app-capable" content="yes" />      

        <?php /* meta tags for facebook share */ ?>

        <meta property="og:title" content="<? echo $site_name = (isset($share_title)) ? $share_title : ''; ?>"/>
        <meta property="og:image" content="<? echo $image_url = (isset($image_url)) ? $image_url : ''; ?>"/>
        <meta property="og:site_name" content="<? echo $site_name = (isset($site_name)) ? $site_name : ''; ?>"/>         
        <meta property="og:description" content="<? echo $description = (isset($description)) ? $description : ''; ?>"/>

        <title>
            <?php
            if (isset($title))
                echo $title = ($title != '') ? $title : 'bitcoin-trade';
            else
                echo 'bitcoin-trade';
            ?>
        </title> 
        <script type="text/javascript">
            var javascript_site_path = "<?php echo base_url(); ?>";
            var javascript_fb_app_id = "<?php echo $global['facebook_app_id']; ?>";
        </script>                

        <link href="<?php echo base_url(); ?>media/front/css/style.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>media/front/css/mobile-media.css" rel="stylesheet" type="text/css">
        <?php if (isset($include_css)) echo $include_css; ?>
        <script src="<?php echo base_url(); ?>media/front/js/jquery-1.10.2.min.js"></script>
        <script src="<?php echo base_url(); ?>media/front/js/facebookbutton.js"></script>
        <?php if (isset($include_js)) echo $include_js; ?>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
        <!--[if !IE]><!--><script>  
            if (/*@cc_on!@*/false) {  
                document.documentElement.className+=' ie10';  
            }  
        </script><!--<![endif]-->  
        <script>
            jQuery().ready(function(e) {	
                //                $(".close,.alert").slideUp(4000); 
                /* for notification message */
                jQuery('.close').click(function() {
                    $(this).parent('div').slideUp('slow');
                });
               
                jQuery("header .arrow_lang").click(function(){
                    jQuery(".sub_menu_02").toggle(300);
                });	
                jQuery("header .arrow_wide").click(function(){
                    jQuery(".sub_menu_01").toggle(300);
                });	
                jQuery("header .arrow_profile").click(function(){
                    if ($(".profile_menu").is(":hidden"))
                        $(".profile_menu").toggle(300);
                    else {
                        $(".profile_menu").hide();
                    }
                    return false;
                });
                $(".profile_menu").click (function(e){
                    e.stopPropagation();
                });
                $(document).click(function(){
                    $(".profile_menu").hide(300);
                });
            
                $("header .menu-button").click(function(){
                    if ($(".mobile_menu").is(':hidden'))
                        $(".mobile_menu").toggle(300);
                    else{
                        $(".mobile_menu").hide();
                    }
                    return false;
                });

                $('.mobile_menu').click(function(e) {
                    e.stopPropagation();
                });                	
                jQuery("header .arrow").click(function(){
                    if ($(".sub_menu").is(":hidden"))
                        $(".sub_menu").toggle(300);
                    else {
                        $(".sub_menu").hide();
                    }
                    return false;
                });
                $(".sub_menu").click (function(e){
                    e.stopPropagation();
                });
                $(document).click(function(){
                    $(".sub_menu").hide(300);
                });			
				

				/* Make table row clickable */
				$('.clickable tr').click(function() {
					var href = $(this).find("a").attr("href");
					if(href) {
						window.location = href;
					}
				});				
				           					
            });        
        </script>    
    </head>
    <body>
        <div id="fb-root"></div>
        <header>
            <div class="page_holder">
                <div class="page_inner">
                    <div class="logo">
                        <a href="<?php echo base_url(); ?>">LOGO HERE</a>
                    </div>
                    <div class="nav_otr">
                        <div class="signup_link">                	
                            <div class="menu">
                                <ul>
                                    <li class="fb_like"><div class="fb-like" data-href="<?php echo $global['facebook_link']; ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div></li>
                                    <li class="fb_like"><div class="g-plusone" data-size="medium" data-href="<?php echo $global['google_plus_link']; ?>"></div></li>																		
                                    <?php if ((isset($user_session['user_id'])) && (!empty($user_session['user_id']))) { ?>
                                        <li class="drops"><a href="javascript:void(0);"><?php echo lang('welcome'); ?> <?php echo ucfirst($user_session['user_name']); ?>!<span class="arrow_profile"></span></a>
                                            <ul class="profile_menu">
                                                <li><a  title="Dashboard" href="<?php echo base_url(); ?>user-dashboard" ><span class="dashboard">&nbsp;</span>Dashboard</a></li>
                                                <li><a  title="Public profile" href="<?php echo base_url(); ?>profile/<?php echo $user_session['user_name']; ?>" ><span class="profile_public">&nbsp;</span>Public profile</a></li>
                                                <li><a  title="Edit profile" href="<?php echo base_url(); ?>profile/edit" ><span class="edit_profile">&nbsp;</span>Edit profile</a></li>
                                                <!--<li><a  title="Trusted" href="<?php echo base_url(); ?>" ><span class="trusted">&nbsp;</span>Trusted</a></li>-->
                                                <li><a  title="Logout" href="<?php echo base_url(); ?>logout" ><span class="logout">&nbsp;</span>Logout</a></li>
                                            </ul>
                                        <?php } else { ?>
                                        <li><a href="<?php echo base_url(); ?>signup"><?php echo lang('sign_up'); ?></a></li> 
                                        <li><a href="<?php echo base_url(); ?>signin"><?php echo lang('login'); ?></a></li>                                                           
                                    <?php } ?>
                                </ul>
                            </div> 	
                        </div>
                        <div class="menu">
                            <div class="menu-button"><img src="<?php echo base_url(); ?>media/front/images/menu_mobile.png" alt="Menu" title="Main menu"></div>
                            <ul class="mobile_menu">
                                <li><a <?php echo ($menu_active == "home") ? 'class="menu_active"' : ""; ?>  href="<?php echo base_url(); ?>"><?php echo lang('home'); ?></a></li> 
                                <li><a <?php echo ($menu_active == "about") ? 'class="menu_active"' : ""; ?> href="<?php echo base_url(); ?>cms/17/about"><?php echo lang('about'); ?></a></li> 
                                <li><a <?php echo ($menu_active == "buy_bitcoin") ? 'class="menu_active"' : ""; ?> href="<?php echo base_url(); ?>buy-bitcoins"><?php echo lang('buy_bitcoins'); ?></a></li> 
                                <li><a <?php echo ($menu_active == "sell_bitcoin") ? 'class="menu_active"' : ""; ?> href="<?php echo base_url(); ?>sell-bitcoins"><?php echo lang('sell_bitcoins'); ?></a></li> 
                                <li><a <?php echo ($menu_active == "post_trade") ? 'class="menu_active"' : ""; ?> href="<?php echo base_url(); ?>advertise"><?php echo lang('post_a_trade'); ?></a></li>      
                                <li><a <?php echo ($menu_active == "forums") ? 'class="menu_active"' : ""; ?> href="<?php echo base_url(); ?>forum"><?php echo lang('forums'); ?></a></li> 
                                <li class="menudrops"><a <?php echo ($menu_active == "info") ? 'class="menu_active"' : ""; ?> href="#"><?php echo lang('info'); ?><span class="arrow"></span></a>
                                    <ul class="sub_menu">
                                        <li class="widedrops"><a  title="Guides" href="javascript:void(0)" >Guides<span class="arrow_wide">&nbsp;</span></a>
                                            <ul class="sub_menu_01">
                                                <li><a  title="Guides" href="<?php echo base_url(); ?>cms/17/faq" >Frequently Asked Questions<span>&nbsp;</span></a></li>
                                                <li><a  title="Fees" href="<?php echo base_url(); ?>cms/17/how-to-buy-bitcoins" >How to buy bitcoins</a></li>
                                                <li><a  title="Blog" href="<?php echo base_url(); ?>cms/17/introduction-to-bitcoins" >Introduction to bitcoins</a></li>
                                                <li><a  title="Statistics" href="<?php echo base_url(); ?>cms/17/security" >Security</a></li>
                                                <li><a  title="" href="<?php echo base_url(); ?>cms/17/selling-bitcoins-online-guide" >Selling bitcoins online guide</a></li>
                                                <li><a  title="" href="<?php echo base_url(); ?>cms/17/running-cash-exchange-guide" >Running cash exchange guide</a></li>
                                                <li><a  title="" href="<?php echo base_url(); ?>cms/17/real-name" >Requiring real name</a></li>
                                                <li><a  title="" href="<?php echo base_url(); ?>cms/17/pricing" >Pricing</a></li>
                                                <li><a  title="" href="<?php echo base_url(); ?>cms/17/api-documentation" >API documentation</a></li>
                                            </ul>
                                        </li>
                                        <li><a  title="Fees" href="<?php echo base_url(); ?>cms/17/fees" >Fees</a></li>
                                        <li><a  title="Blog" href="<?php echo base_url(); ?>cms/17/blog" >Blog</a></li>
                                        <li><a  title="Statistics" href="<?php echo base_url(); ?>cms/17/statistics" >Statistics</a></li>
                                        <li><a  title="About Us" href="<?php echo base_url(); ?>cms/17/about" >About Us</a></li>
                                    </ul>
                                </li>
                                <li><a  href="#"><?php echo lang('english'); ?><span class="arrow_lang"></span></a></li>                                   
                            </ul>
                        </div>
                    </div>            
                </div>
            </div>
        </header>
        <?php
        /* Start:: This section for showing only messages */
        ?>
        <section id="messages">
            <div class="page_holder">
                <?php if ($this->session->userdata('register_success') != '') { ?>
                    <div class="alert alert-success">
                        <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
                        <strong>Congratulations!</strong> <?php echo $this->session->userdata('register_success'); ?>
                    </div>
                    <?php
                    $this->session->unset_userdata('register_success');
                }
                ?>
                <?php if ($this->session->userdata('msg') != '') { ?>
                    <div class="alert alert-success">
                        <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
                        <?php echo $this->session->userdata('msg'); ?>
                    </div>
                    <?php
                    $this->session->unset_userdata('msg');
                }
                ?>
                <?php if ($this->session->userdata('msg-error') != '') { ?>
                    <div class="alert alert-error">
                        <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
                        <?php echo $this->session->userdata('msg-error'); ?>
                    </div>
                    <?php
                    $this->session->unset_userdata('msg-error');
                }
                ?>
                <?php if (validation_errors() != '') { ?>
                    <div class="alert alert-error">
                        <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
                        <?php echo validation_errors(); ?>
                    </div>
                <?php } ?>
                <?php if ($this->session->userdata('login_error') != '') { ?>
                    <div class="alert alert-error">
                        <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
                        <strong></strong> <?php echo $this->session->userdata('login_error'); ?>
                    </div>
                    <?php
                    $this->session->unset_userdata('login_error');
                }
                ?>
                <?php if ($this->session->userdata('activation_success') != '') { ?>
                    <div class="alert alert-success">
                        <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
                        <strong></strong> <?php echo $this->session->userdata('activation_success'); ?>
                    </div>
                    <?php
                    $this->session->unset_userdata('activation_success');
                }
                ?>
                <?php if ($this->session->userdata('activation_error') != '') { ?>
                    <div class="alert alert-error">
                        <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
                        <strong></strong> <?php echo $this->session->userdata('activation_error'); ?>
                    </div>
                    <?php
                    $this->session->unset_userdata('activation_error');
                }
                ?>
                <?php if ($this->session->userdata('password_recover') != '') { ?>  
                    <div class="alert alert-success">
                        <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
                        <strong></strong> <?php echo $this->session->userdata('password_recover'); ?>
                    </div>
                    <?php
                    $this->session->unset_userdata('password_recover');
                }
                ?>
                <?php if ($this->session->userdata('deletion_success') != '') { ?>
                    <div class="alert alert-success">
                        <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
                        <?php echo $this->session->userdata('deletion_success'); ?>
                    </div>
                    <?php
                    $this->session->unset_userdata('deletion_success');
                }
                ?>       
                <?php if ($this->session->userdata('edit_profile_success') != '') { ?>
                    <div class="alert alert-success">
                        <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
                        <?php echo $this->session->userdata('edit_profile_success'); ?>
                    </div>
                    <?php
                    $this->session->unset_userdata('edit_profile_success');
                }
                ?>
            </div>
        </section>
        <?php /* END: This section for showing only messages */ ?>
