<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo isset($title) ? $title : ''; ?>-Admin Panel</title>
        <?php $this->load->view('backend/sections/header.php'); ?>
        <script src="<?php echo base_url(); ?>admin-media/js/jquery.dataTables.min.js"></script> 
        <script src="<?php echo base_url(); ?>admin-media/js/bootstrap-tab.js"></script>
        <!-- library for advanced tooltip -->
        <script src="<?php echo base_url(); ?>admin-media/js/bootstrap-tooltip.js"></script>
        <script src="<?php echo base_url(); ?>admin-media/js/charisma.js"></script> 
    </head>
    <body>
        <?php $this->load->view('backend/sections/top-nav.php'); ?>
        <?php $this->load->view('backend/sections/leftmenu.php'); ?>

        <div id="content" class="span10">
            <!--[breadcrumb]-->
            <div>
                <ul class="breadcrumb">
                    <li> <a href="javascript:void(0)">Dashboard</a> <span class="divider">/</span> </li>
                    <li> <a href="<?php echo base_url(); ?>backend/email-template/list">Manage Email Templates</a> </li>
                </ul>
            </div>

            <!--[message box]-->
            <?php if ($this->session->userdata('msg') != '') { ?>
                <div class="msg_box alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" id="msg_close" name="msg_close">×</button>
                    <?php echo $this->session->userdata('msg'); ?> </div>
                <?php
                $this->session->unset_userdata('msg');
            }
            ?>
            <div class="row-fluid sortable"> 
                <!--[sortable header start]-->
                <div class="box span12">
                    <div class="box-header well">
                        <h2><i class=""></i>Email Templates Management</h2>
                    </div>
                    <br >
                    <!--[sortable body]-->
                    <div class="box-content">
                        <table  class="table table-striped table-bordered bootstrap-datatable datatable">
                            <thead>
                            <th width="25%" class="workcap">Title</th>
                            <th width="25%" class="workcap">Subject</th>
                            <th width="10%" class="workcap">Language</th>
                            <th width="12%" class="workcap">Created On</th>
                            <th width="12%" class="workcap">Updated On</th>
                            <th width="16%" class="workcap" align="center">Action</th>
                            </thead>
                            <tbody>
                                <?php
                                $cnt = 0;
                                foreach ($arr_email_templates as $email_template) {
                                    $cnt++;
                                    ?>
                                    <tr>
                                        <td class="worktd"  align="left"><?php echo ucwords(str_replace("-", " ", $email_template['email_template_title'])); ?></td>
                                        <td class="worktd"  align="left"><?php echo $email_template['email_template_subject']; ?></td>
                                        <td class="worktd"  align="left"><?php echo $email_template['lang_name']; ?></td>
                                        <td class="worktd"  align="left"><?php echo date("Y-m-d", strtotime($email_template['date_created'])); ?></td>
                                        <td class="worktd"  align="left"><?php echo date("Y-m-d", strtotime($email_template['date_updated'])); ?></td>
                                        <td class="worktd">
                                            <a class="btn btn-info" href="<?php echo base_url(); ?>backend/edit-email-template/<?php echo $email_template['email_template_id']; ?>" title="Edit Email Template">
                                                <i class="icon-edit icon-white"></i>Edit</a> 
                                        </td>
                                        <?php
                                    }
                                    ?>
                            </tbody>

                        </table>
                    </div>
                    <!--[sortable body]--> 
                </div>
            </div>

            <!--[sortable table end]--> 

            <!--[include footer]-->
        </div>

    </div>

    <!--including footer here-->
    <?php $this->load->view('backend/sections/footer.php'); ?>
</div>


</body>
</html>