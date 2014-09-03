<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo isset($title) ? $title : ''; ?>-Admin Panel</title>
        <?php $this->load->view('backend/sections/header.php'); ?>
        <script src="<?php echo base_url(); ?>media/backend/js/jquery.dataTables.min.js"></script> 
        <script src="<?php echo base_url(); ?>media/backend/js/bootstrap-tab.js"></script>
        <!-- library for advanced tooltip -->
        <script src="<?php echo base_url(); ?>media/backend/js/bootstrap-tooltip.js"></script>
        <script src="<?php echo base_url(); ?>media/backend/js/charisma.js"></script> 

    </head>
    <body>
        <?php $this->load->view('backend/sections/top-nav.php'); ?>
        <?php $this->load->view('backend/sections/leftmenu.php'); ?>

        <div id="content" class="span10">
            <!--[breadcrumb]-->
            <div>
                <ul class="breadcrumb">
                    <li> <a href="javascript:void(0)">Dashboard</a> <span class="divider">/</span> </li>
                    <li> <a href="<?php echo base_url(); ?>backend/forum-categories">Manage Forum Categories</a> </li>
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
                        <h2><i class=""></i>Forum Categories Management</h2>
<!--                        <div class="box-icon">
                            <a title="Add new Category" class="btn btn-plus btn-round" href="<?php echo base_url(); ?>backend/forum-add-category"><i class="icon-plus"></i></a>
                        </div>-->
                    </div>
                    <br>
                    <!--[sortable body]-->
                    <div class="box-content">
                        <table  class="table table-striped table-bordered bootstrap-datatable datatable">
                            <thead>
                            <th width="2%" class="workcap">#</th>
                            <th width="25%" class="workcap">Category name</th>
                            <?php /* <th width="25%" class="workcap">Parent Category</th> */ ?>
                            <th width="15%" class="workcap">Page url</th>
                            <th width="15%" class="workcap">Created On</th>                        
                            <th width="16%" class="workcap" align="center">Action</th>
                            </thead>
                            <tbody>
                                <?php
                                $cnt = 0;
                                foreach ($arr_froum_categories_list as $arr_category) {
                                    $cnt++;
                                    ?>
                                    <tr>
                                        <td class="worktd"  align="left"><?php echo $cnt; ?></td>
                                        <td class="worktd"  align="left"><?php echo ucfirst($arr_category['category_name']); ?></td>
                                        <?php /*  <td class="worktd"  align="left"><?php echo $arr_category['parent_category']; ?></td> */ ?>
                                        <td class="worktd"  align="left"><?php echo ($arr_category['page_url'] == "") ? "" : $arr_category['page_url']; ?></td>
                                        <td class="worktd"  align="left"> <?php echo date($global['date_format'], strtotime($arr_category['created_on'])); ?></td>

                                        <td class="worktd">
                                            <a class="btn btn-info" href="<?php echo base_url(); ?>backend/forum-category-edit/<?php echo $arr_category['category_id']; ?>" title="Edit Category">
                                                <i class="icon-edit icon-white"></i>Edit</a>                                                
                                                <!--<a title="Edit category for other Langauages" href="<?php echo base_url(); ?>backend/forum-category-edit-multilingual/<?php echo $arr_category['category_id']; ?>" class="btn btn-primary">
    <i class="icon-file icon-white"></i>Multilangual</a>-->
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
