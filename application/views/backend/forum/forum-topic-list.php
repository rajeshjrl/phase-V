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
        <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
        <script src="<?php echo base_url(); ?>media/front/js/forum-topic.js"></script>
        <script>
            var SITE_PATH = '<?php echo base_url(); ?>';
            setInputP('<?php echo $topic_id; ?>');
        </script>

    </head>
    <body>
        <?php $this->load->view('backend/sections/top-nav.php'); ?>
        <?php $this->load->view('backend/sections/leftmenu.php'); ?>

        <div id="content" class="span10">
            <!--[breadcrumb]-->
            <div>
                <ul class="breadcrumb">
                    <li> <a href="javascript:void(0)">Dashboard</a> <span class="divider">/</span> </li>
                    <li> <a href="<?php echo base_url(); ?>backend/forum-list"> Manage Forum List </a> </li>
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
                    <?php foreach ($forum_topics as $topic) { ?>
                        <div class="box-header well">
                            <h2><i class=""></i><?php echo $topic["topic_title"]; ?></h2>
                            <div class="box-icon">
                                <a title="Topic Details Page" class="btn btn-plus btn-round" href="<?php echo base_url(); ?>backend/forum-list"><i class="icon-arrow-left"></i></a>
                            </div>

                        </div>
                        <div  class="article">
                            <article>
                                <?php echo stripslashes($topic["topic_content"]); ?>
                            </article>
                            <div class="topic-footer">Posted on : <?php echo date("d<\s\up>S</\s\up> M Y h:i A", strtotime($topic["posted_on"])); ?></div>
                        </div>
                    <?php } ?>          
                    <br >
                    <!--[sortable body]-->
                    <div class="box-content">

                        <style>
                            .article{
                                background: none repeat scroll 0 0 #CCCCCC;
                                border-radius: 5px;
                                margin: 0;
                                min-height: 50px;
                                padding: 10px;
                                width: 96%;
                                margin:1%;
                            }
                            .topic-footer{
                                float:right;
                            }					
                            .well{
                                padding:10px;
                            }	
                        </style>	

                        <div style="width:100%;display:inline-block;">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3>Comments</h3>
                                </div>
                                <?php foreach ($topic_comments as $comment) { ?>
                                    <div class="well">
                                        <p><?php echo nl2br(stripslashes($comment["comment"])); ?></p>
                                        <p class="pull-left">&dash; <?php
                                if (isset($topic_id)) {
                                    echo stripslashes($comment["user_name"]);
                                }
                                    ?></p>
                                        <p class="pull-right">Commented on : <?php echo date("d<\s\up>S</\s\up> M Y h:i A", strtotime($comment["comment_on"])); ?></p><p class="clearfix"></p>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>

                            <div class="forum-row">
                                <form class="form" name="frmComments" id="frmComments" method="post">
                                    <div class="control-group">
                                        <label class="control-label" for="inputComment">Post your comment</label>
                                        <div class="controls">
                                            <textarea name="inputComment" id="inputComment" placeholder="enter your comment here" style="width:30%;"></textarea>
                                            <div class="text-danger error" for="inputComment"></div>
                                        </div>
                                    </div>
                                    <div class="comment-footer">
                                        <button id="btnPostComment" type="button">Post your comment</button>
                                    </div>
                                </form>
                            </div>
                        </div>
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
