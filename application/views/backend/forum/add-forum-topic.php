<!DOCTYPE html>
<html lang="en">
    <head> 
        <title><?php echo isset($title) ? $title : ''; ?>-Admin Panel</title>
        <?php $this->load->view('backend/sections/header.php'); ?>
        <style>
            .error {
                color: #BD4247;
                margin-left: 120px;
                width: 210px;
            }
            .FETextInput.error {
                width: 210px !important;
            }
        </style>
        <script src="<?php echo base_url(); ?>media/backend/js/jquery.validate.min.js"></script>
        <script> var SITE_PATH = '<?php echo base_url(); ?>';</script>
        <script src="<?php echo base_url(); ?>media/front/js/forum-add-topic.js"></script>
        <!--<script src="<?php echo base_url(); ?>media/front/js/forum-edit-topic.js"></script> -->
        <script src="<?php echo base_url(); ?>media/front/js/jquery.cleditor.min.js"></script>
        <link href="<?php echo base_url(); ?>media/front/css/jquery.cleditor.css" type="text/css" rel="stylesheet">
    </head>
    <body>
        <?php $this->load->view('backend/sections/top-nav.php'); ?>
        <?php $this->load->view('backend/sections/leftmenu.php'); ?>
        <div id="content" class="span10">
            <!--[breadcrumb]-->
            <div>
                <ul class="breadcrumb">
                    <li> <a href="javascript:void(0)">Dashboard</a> <span class="divider">/</span> </li>
                    <li> <a href="<?php echo base_url(); ?>backend/forum-list">Manage Forum Topics</a><span class="divider">/</span> </li>
                    <li> <a href="javascript:void(0);">Add Forum Topics</a> </li>
                </ul>
            </div>
            <div class="row-fluid sortable"> 
                <!--[sortable header start]-->
                <div class="box span12">
                    <div class="box-header well">
                        <h2><i class=""></i>Add Forum Topic</h2>
                        <div class="box-icon">
                            <a title="Manage Forum Topics" class="btn btn-plus btn-round" href="<?php echo base_url(); ?>backend/forum-list"><i class="icon-arrow-left"></i></a>
                        </div>

                    </div>
                    <br >
                    <!--[sortable body]-->
                    <div class="box-content">
                        <form name="frmForumTopic" id="frmForumTopic" action="#" method="post" >
                            <input type="hidden" name="topic_id" id="topic_id" value="<?php echo(isset($forum_topics['topic_id'])) ? $forum_topics['topic_id'] : ''; ?>">
                            <div class="control-group">
                                <label class="control-label" for="inputForumTitle">Topic Title <sup style="color: red;">*</sup></label>
                                <div class="controls">
                                    <input type="text" dir="ltr" style="margin-left:200px; margin-top:-28px" class="FETextInput"  placeholder="Enter title here" id="inputForumTitle" name="inputForumTitle" value="" />
                                </div>
                            </div>

<!--                            <div class="control-group">
                                <label class="control-label" for="inputForumTopicShortDescription">Short Description </label>
                                <div class="controls">
                                    <textarea dir="ltr" style="margin-left:200px; margin-top:-28px" class="FETextInput"  name="inputForumTopicShortDescription" id="inputForumTopicShortDescription" placeholder="Enter topic short description here"></textarea>
                                </div>
                            </div>-->

                            <div class="control-group">
                                <label class="control-label" for="inputForumTopicDescription">Description </label>
                                <div class="controls">
                                    <textarea dir="ltr" style="margin-left:200px; margin-top:-28px" class="FETextInput"  name="inputForumTopicDescription" id="inputForumTopicDescription"></textarea>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="inputCategory">Select Category </label>
                                <div class="controls">
                                    <?php
                                    echo '<select id="inputCategory" name="inputCategory" dir="ltr" style="margin-left:200px; margin-top:-28px" class="FETextInput" >' . $str_categories_menu_select . "</select>";
                                    ?>
                                </div>
                            </div>




                            <div class="control-group">
                                <label class="control-label" for="inputForumTopicPageTitle">Page title </label>
                                <div class="controls">
                                    <input type="text" dir="ltr" style="margin-left:200px; margin-top:-28px" class="FETextInput"  placeholder="Enter topic page title" id="inputForumTopicPageTitle" name="inputForumTopicPageTitle" value="">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="inputForumTopicMetaKeywords">Page Keywords </label>
                                <div class="controls">
                                    <textarea dir="ltr" style="margin-left:200px; margin-top:-28px" class="FETextInput"  placeholder="Enter topic meta keywords" id="inputForumTopicMetaKeywords" name="inputForumTopicMetaKeywords"></textarea>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="inputForumTopicMetaDescription">Page Description </label>
                                <div class="controls">
                                    <textarea dir="ltr" style="margin-left:200px; margin-top:-28px" class="FETextInput"  placeholder="Enter topic meta description" id="inputForumTopicMetaDescription" name="inputForumTopicMetaDescription"></textarea>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="page_url">Page Url <sup style="color: red;">*</sup></label>
                                <div class="controls">
                                    <input type="text" required dir="ltr" style="margin-left:200px; margin-top:-28px" class="FETextInput" name="page_url" value="" id="page_url" />
                                </div>
                            </div>

                            <div class="form-actions">
                                <button class="btn btn-primary" id="btnAddTopic" type="button">Post your topic</button>
                            </div>
                        </form>
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
</body>
</html>
<style>
    .error{
        color: #BD4247;
        margin-left: 202px;
        width: 400px;
    }
</style>
