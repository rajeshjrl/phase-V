<!-- topbar starts -->
<div class="navbar">
    <div class="navbar-inner">
        <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>"  />
        <div class="container-fluid"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a> <a class="brand" href="<?php echo base_url(); ?>backend/dashboard"> <img alt="Logo" src="<?php echo base_url(); ?>media/backend/img/logo20.png" /> <span><?php echo $global['site_title']; ?></span></a>
            <!-- user dropdown starts -->
            <div class="btn-group pull-right" > 
                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"> 
                    <i class="icon-user"></i><span class="hidden-phone"><?php echo $user_account['user_name']; ?></span> <span class="caret"></span> 
                </a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url(); ?>backend/admin/profile"><?php echo $user_account['first_name'] . " " . $user_account['last_name']; ?></a></li>	
                    <li><a href="<?php echo base_url(); ?>backend/admin/edit-profile">Edit Profile</a></li>	                    
                    <li><a href="<?php echo base_url(); ?>backend/log-out">Logout</a></li>
                </ul>
            </div>
            <!-- user dropdown ends -->

            <div class="top-nav nav-collapse">
                <ul class="nav">
                    <li><a href="<?php echo base_url(); ?>" target="_blank">Visit Site</a></li>
                </ul>
            </div>
            <!--/.nav-collapse --> 
        </div>
    </div>
</div>
<!-- topbar ends -->
