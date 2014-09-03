<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo (isset($title)) ? $title : $global['site_title']; ?></title>
        <?php $this->load->view('backend/sections/header'); ?>
        <style>
            .error {
                color: #BD4247;
                margin-left: 140px;
                width: 210px;
            }
            .FETextInput{
                margin-left: 120px;
                margin-top: -28px;
            }
        </style>
        <!-- validation js -->
        <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>media/backend/js/jquery.validate.min.js"></script>
    </head>
    <body>
        <?php $this->load->view('backend/sections/top-nav.php'); ?>
        <?php $this->load->view('backend/sections/leftmenu.php'); ?>
        <div id="content" class="span10">
            <!--[breadcrumb]-->
            <div>
                <ul class="breadcrumb">
                    <li> <a href="<?php echo base_url(); ?>backend/dashboard">Dashboard</a> <span class="divider">/</span> </li>
                    <li> <a href="<?php echo base_url(); ?>backend/role/list">Manage Roles</a> <span class="divider">/</span></li>
                    <li> <?php echo ((isset($edit_id) && $edit_id != "") ? "Update" : "Add"); ?> Role </li>
                </ul>
            </div>

            <div class="row-fluid sortable"> 
                <!--[sortable header start]-->
                <div class="box span12">
                    <div class="box-header well">
                        <h2><i class=""></i><?php echo ((isset($edit_id) && $edit_id != "") ? "Update" : "Add"); ?> Role</h2>
                        <div class="box-icon">
                            <a title="Manage Role" class="btn btn-plus btn-round" href="<?php echo base_url(); ?>backend/role/list"><i class="icon-arrow-left"></i></a>
                        </div>
                    </div>
                    <br >
                    <!--[sortable body]-->
                    <div class="box-content">
                        <form name="frm_role" id="frm_role" action="<?php echo base_url(); ?>backend/role/add" method="POST" >
                            <?php
                            if (isset($edit_id) && $edit_id != '') {
                                ?>
                                <input type="hidden" name="frm_type" id="frm_type" value="edit" />
                                <input type="hidden" name="old_role_name" id="old_role_name" value="<?php
                            if (isset($arr_role['role_name'])) {
                                echo str_replace('"', '&quot;', stripslashes($arr_role['role_name']));
                            }
                                ?>" />
                                       <?php
                                   } else {
                                       ?>
                                <input type="hidden" name="frm_type" id="frm_type" value="add" />	
                                <input type="hidden" name="old_role_name" id="old_role_name" value="" />
                                <?php
                            }
                            ?>
                            <div class="control-group">
                                <label class="control-label" for="inputQuestion">Role Name<sup class="mandatory">*</sup></label>
                                <div class="controls">
                                    <input type="text" dir="ltr" style="margin-left:140px; margin-top:-28px" class="FETextInput" name="role_name" id="role_name" value="<?php
                            if (isset($arr_role['role_name'])) {
                                echo str_replace('"', '&quot;', stripslashes($arr_role['role_name']));
                            }
                            ?>" size="80" />
                                </div>
                            </div>

                            <div class="control-group">
                                <label for="typeahead" class="control-label">Choose Role Privilages<sup class="mandatory">*</sup> </label>
                                <div class="controls">
                                    <?php foreach ($arr_privileges as $key => $privilege) {
                                        ?>
                                        <p style="margin-left:140px;">
                                            <input type="checkbox" name="role_privileges[]" id="role_privileges" value="<?php echo $privilege['privileges_id'] ?>"  <?php
                                    if (isset($edit_id) && $edit_id != '') {
                                        if (in_array($privilege['privileges_id'], $arr_role_privileges)) {
                                                ?> checked="checked" <?php
                                           }
                                       }
                                        ?>> <?php echo ucwords($privilege['privilege_name']); ?>
                                        </p>
<?php } ?>
                                </div>



                                <div id="pre_div">

                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" name="btn_submit" class="btn btn-primary" value="Save changes">Save changes</button>
                                <input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>">
                            </div>

                        </FORM>
                    </div>
                    <!--[sortable body]--> 
                </div>
            </div>

            <!--[sortable table end]--> 

            <!--[include footer]-->
        </div><!--/#content.span10-->

    </div><!--/fluid-row-->
<?php $this->load->view('backend/sections/footer.php'); ?>
</div>
<script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>media/backend/js/role-manage/add-edit-role.js"></script>
</body>
</html>

