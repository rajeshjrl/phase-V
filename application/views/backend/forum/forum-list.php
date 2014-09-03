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
                    <li> <a href="<?php echo base_url(); ?>backend/forum-list">Manage Forum List</a> </li>
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
                        <h2><i class=""></i>Forum Topic Management</h2>
                        <div class="box-icon">
                            <a title="Add new topic" class="btn btn-plus btn-round" href="<?php echo base_url(); ?>backend/forum-topic-add"><i class="icon-plus"></i></a>
                        </div>
                    </div                    
                    ><br >
                    <!--[sortable body]-->
                    <div class="box-content">
                        <table  class="table table-striped table-bordered bootstrap-datatable datatable">
                            <thead>
                            <th width="3%" class="workcap">#</th>
                            <th width="25%" class="workcap">Topic Title</th>
                            <th width="15%" class="workcap">Category</th>
                            <th width="15%" class="workcap">Page url</th>
                            <th width="10%" class="workcap">Status</th>
                            <th width="15%" class="workcap">Created On</th>                        
                            <th width="16%" class="workcap" align="center">Action</th>
                            </thead>
                            <tbody>
                                <?php
                                $cnt = 0;
                                foreach ($forum_topics as $forum_topic) {
                                    $cnt++;
                                    ?>
                                    <tr>
                                        <td class="worktd"  align="left"><?php echo $cnt; ?></td>
                                        <td class="worktd"  align="left"><?php echo ucfirst($forum_topic['topic_title']); ?></td>
                                        <td class="worktd"  align="left"><?php echo (trim($forum_topic['category_name']) == "") ? "-" : $forum_topic['category_name']; ?></td>
                                        <td class="worktd"  align="left"><?php echo (trim($forum_topic['page_url']) == "") ? "-" : $forum_topic['page_url']; ?></td>
                                        <td class="worktd"  align="left">
                                            <?php if ($forum_topic['status'] == 0) { ?>
                                                <a style="cursor:default;" class="label label-warning" href="<?php echo base_url(); ?>backend/forum-topic-status/1/<?php echo $forum_topic['topic_id']; ?>" id="status_<?php echo $forum_topic['topic_id']; ?>">Inactive</a>
                                                <?php
                                            } else {
                                                ?>
                                                <a class="label label-success" title="Click to Change Status" href="<?php echo base_url(); ?>backend/forum-topic-status/0/<?php echo $forum_topic['topic_id']; ?>" id="status_<?php echo $forum_topic['topic_id']; ?>">Active</a>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td class="worktd"  align="left"> <?php echo date($global['date_format'], strtotime($forum_topic['posted_on'])); ?></td>
                                        <td class="worktd">
                                            <a class="btn btn-info" href="<?php echo base_url(); ?>backend/forum-topic-edit/<?php echo $forum_topic['topic_id']; ?>" title="Edit Topic">
                                                <i class="icon-edit icon-white"></i>Edit</a> 
                                            <a class="btn btn-info" href="<?php echo base_url(); ?>backend/forum-topic-comments/<?php echo $forum_topic['page_url']; ?>" title="View Topic & its Comments">
                                                <i class="icon-list icon-white"></i>View</a>                                               
                                        </td>
                                    <?php } ?>
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
