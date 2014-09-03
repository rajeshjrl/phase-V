<div class="container-fluid">
    <div class="row-fluid">
        <?php if ($user_account['role_id'] == 1) { ?>
            <!-- left menu starts -->
            <div class="span2 main-menu-span">

                <div class="well nav-collapse sidebar-nav">

                    <ul class="nav nav-tabs nav-stacked main-menu">

                        <li class="nav-header hidden-tablet">Global Settings</li>

                        <li> <a class="ajax-link" href="<?php echo base_url(); ?>backend/global-settings/list"><i class="icon-globe"></i> <span class="hidden-tablet">Manage Global Settings</span></a> </li>
                        <li class="nav-header hidden-tablet">Role Section</li>

                        <li> <a class="ajax-link" href="<?php echo base_url(); ?>backend/role/list"><i class="icon-adjust"></i> <span class="hidden-tablet">Manage Roles</span></a> </li> 	

                        <li class="nav-header hidden-tablet">User Section</li>       

                        <li> <a class="ajax-link" href="<?php echo base_url(); ?>backend/admin/list"><i class="icon-user"></i> <span class="hidden-tablet">Manage Admin</span></a> </li> 
                        <li> <a class="ajax-link" href="<?php echo base_url(); ?>backend/user/list"><i class="icon-user"></i> <span class="hidden-tablet">Manage User</span></a> </li>
                        <li> <a class="ajax-link" href="<?php echo base_url(); ?>backend/user/log-list"><i class="icon-user"></i> <span class="hidden-tablet">User Log</span></a> </li>
                        <li> <a class="ajax-link" href="<?php echo base_url(); ?>backend/user/deletion-list"><i class="icon-user"></i> <span class="hidden-tablet">User Deletion Requests</span></a> </li>

                        <li class="nav-header hidden-tablet">Email Templates Section</li>
                        <li> <a style="cursor: pointer;" class="ajax-link" href="<?php echo base_url(); ?>backend/email-template/list"><i class="icon-envelope"></i> <span class="hidden-tablet">Manage Email Templates</span></a> </li>

                        <li class="nav-header hidden-tablet">Manage CMS</li>       
                        <li> <a class="ajax-link" href="<?php echo base_url(); ?>backend/cms"><i class="icon-file"></i> <span class="hidden-tablet">Manage CMS</span></a> </li> 

                        <li class="nav-header hidden-tablet">currency Section</li>
                        <li> <a style="cursor: pointer;" class="ajax-link" href="<?php echo base_url(); ?>backend/currency/list"><i class="icon-envelope"></i> <span class="hidden-tablet">Manage Currency</span></a> </li>
			<li> <a class="ajax-link" href="<?php echo base_url(); ?>backend/payment-method/list"><i class="icon-envelope"></i> <span class="hidden-tablet">Manage Payment Methods</span></a> </li>

                        <li class="nav-header hidden-tablet">Trusted Section</li>       
                        <li> <a class="ajax-link" href="<?php echo base_url(); ?>backend/accounts/trusted"><i class="icon-eye-open"></i> <span class="hidden-tablet">People trusted</span></a> </li>
                        <li> <a class="ajax-link" href="<?php echo base_url(); ?>backend/accounts/trusted/ads"><i class="icon-eye-open"></i> <span class="hidden-tablet">Trusted advertisement</span></a> </li>

                        <li class="nav-header hidden-tablet">Trade Section</li>       
                        <li> <a class="ajax-link" href="<?php echo base_url(); ?>backend/advertise"><i class="icon-list-alt"></i> <span class="hidden-tablet">Post trade</span></a> </li>
                        <li> <a class="ajax-link" href="<?php echo base_url(); ?>backend/advertise/trade-requests-list"><i class="icon-list-alt"></i> <span class="hidden-tablet">Trade request</span></a> </li>

                        <li class="nav-header hidden-tablet">Manage Apps</li>       
                        <li> <a class="ajax-link" href="<?php echo base_url(); ?>backend/api"><i class="icon-check"></i> <span class="hidden-tablet">Manage api</span></a> </li>
                        <li> <a class="ajax-link" href="<?php echo base_url(); ?>backend/apps"><i class="icon-check"></i> <span class="hidden-tablet">Manage applications</span></a> </li>

                        <li class="nav-header hidden-tablet">Manage forum</li>       
                        <li> <a class="ajax-link" href="<?php echo base_url(); ?>backend/forum-categories"><i class="icon-file"></i> <span class="hidden-tablet">Manage categories</span></a> </li>
                        <li> <a class="ajax-link" href="<?php echo base_url(); ?>backend/forum-list"><i class="icon-file"></i> <span class="hidden-tablet">Manage forum</span></a> </li>
						
			<li class="nav-header hidden-tablet">Manage Wallet</li>
                        <li> <a class="ajax-link" href="<?php echo base_url(); ?>backend/wallet-list"><i class="icon-signal"></i> <span class="hidden-tablet">Bitcoin wallet address</span></a> </li>
						
                    </ul>
                </div>

            </div>
            <!--/span--> 
            <!-- left menu ends -->
            <!-- content starts -->
        <?php } else { ?>
            <div class="span2 main-menu-span">
                <div class="well nav-collapse sidebar-nav">
                    <ul class="nav nav-tabs nav-stacked main-menu"> 
                        <?php
                        $arr_login_admin_privileges = unserialize($user_account['user_privileges']);
                        //print_r($arr_login_admin_privileges);

                        if (count($arr_login_admin_privileges) > 0) {
                            $user_section = TRUE;
                            foreach ($arr_login_admin_privileges as $privilage) {
                                switch ($privilage) {
                                    case 1:
                                        ?>
                                        <li class="nav-header hidden-tablet">Email Templates Section</li>
                                        <?php #will Update this both Link As this Module finish   ?>
                                        <li> <a style="cursor: pointer;" class="ajax-link" href="<?php echo base_url(); ?>backend/email-template/list"><i class="icon-envelope"></i> <span class="hidden-tablet">Manage Email Templates</span></a> </li>

                                        <?php
                                        break;
                                    case 2:
                                        if ($user_section) {
                                            echo '  <li class="nav-header hidden-tablet">User Section</li>';
                                            $user_section = FALSE;
                                        }
                                        ?>

                                        <li> <a class="ajax-link" href="<?php echo base_url(); ?>backend/user/list"><i class="icon-user"></i> <span class="hidden-tablet">Manage User</span></a> </li>
                                        <?php
                                        break;
                                    case 3:
                                        if ($user_section) {
                                            echo '  <li class="nav-header hidden-tablet">User Section</li>';
                                            $user_section = FALSE;
                                        }
                                        ?>
                                        <li> <a class="ajax-link" href="<?php echo base_url(); ?>backend/user/log-list"><i class="icon-user"></i> <span class="hidden-tablet">User Log</span></a> </li>

                                        <?php
                                        break;
                                    case 4:
                                        if ($user_section) {
                                            echo '  <li class="nav-header hidden-tablet">User Section</li>';
                                            $user_section = FALSE;
                                        }
                                        ?>
                                        <li> <a class="ajax-link" href="<?php echo base_url(); ?>backend/user/deletion-list"><i class="icon-user"></i> <span class="hidden-tablet">User Deletion Requests</span></a> </li>

                                        <!--<li class="nav-header hidden-tablet">currency Section</li>
                                        <li> <a style="cursor: pointer;" class="ajax-link" href="<?php echo base_url(); ?>backend/currency/list"><i class="icon-envelope"></i> <span class="hidden-tablet">Manage Currency</span></a> </li>-->
                                        <?php
                                        break;
                                    case 5:
                                        ?>
                                        <li class="nav-header hidden-tablet">Manage CMS</li>       
                                        <li> <a class="ajax-link" href="<?php echo base_url(); ?>backend/cms"><i class="icon-file"></i> <span class="hidden-tablet">Manage CMS</span></a> </li> 
                                        <?php
                                        break;

                                    case 6:
                                        ?>
                                        <li class="nav-header hidden-tablet">Manage Section</li>
                                        <li> <a class="ajax-link" href="<?php echo base_url(); ?>backend/accounts/trusted"><i class="icon-user"></i> <span class="hidden-tablet">People trusted</span></a> </li>
                                        <li> <a class="ajax-link" href="<?php echo base_url(); ?>backend/accounts/trusted/ads"><i class="icon-user"></i> <span class="hidden-tablet">Trusted advertisement</span></a> </li>
                                        <?php
                                        break;


                                    case 7:
                                        ?>
                                        <li class="nav-header hidden-tablet">Currency Section</li>
                                        <li> <a style="cursor: pointer;" class="ajax-link" href="<?php echo base_url(); ?>backend/currency/list"><i class="icon-envelope"></i> <span class="hidden-tablet">Manage Currency</span></a> </li>
                                        <?php
                                        break;

                                    case 8:
                                        ?>
                                        <li class="nav-header hidden-tablet">Trade Section</li>
                                        <li> <a class="ajax-link" href="<?php echo base_url(); ?>backend/advertise"><i class="icon-user"></i> <span class="hidden-tablet">Post trade</span></a> </li>
                                        <?php
                                        break;

                                    case 9:
                                        ?>
                                        <li class="nav-header hidden-tablet">Manage Apps</li>       
                                        <li> <a class="ajax-link" href="<?php echo base_url(); ?>backend/api"><i class="icon-user"></i> <span class="hidden-tablet">Manage api</span></a> </li>
                                        <li> <a class="ajax-link" href="<?php echo base_url(); ?>backend/apps"><i class="icon-user"></i> <span class="hidden-tablet">Manage applications</span></a> </li>
                                        <?php
                                        break;
										
									case 10:
									?>
										<li class="nav-header hidden-tablet">Manage forum</li>       
										<li> <a class="ajax-link" href="<?php echo base_url(); ?>backend/forum-categories"><i class="icon-user"></i> <span class="hidden-tablet">Manage categories</span></a> </li>
										<li> <a class="ajax-link" href="<?php echo base_url(); ?>backend/forum-list"><i class="icon-user"></i> <span class="hidden-tablet">Manage forum</span></a> </li>
									<?php
									break;
                                }
                            }
                        }
                        ?>  
                    </ul>
                </div>

            </div>
        <?php }
        ?>
        <!-- [end:::left menu] --> 