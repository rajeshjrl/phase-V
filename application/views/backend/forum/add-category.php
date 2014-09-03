<?php
/* * making sure that array having only one record.** */
//$arr_email_template_details = end($arr_email_template_details);
?><!DOCTYPE html>
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

        <script type="text/javascript" language="javascript">

            $(document).ready(function(){
	
                jQuery("#frm_currency").validate({
                    errorElement:'label',
                    rules: {
                        category_name:{
                            required: true
                        },
                        page_url:{
                            required: true,
                            remote:{
                                url:"<?php echo base_url(); ?>backend/forum-unique-uri",
                                data:{page_url_old:jQuery("#page_url_old").val()}
                            }
                        }
                    },
                    messages: {
                        category_name:{
                            required: "Please enter the category name."
                        },
                        page_url:{
                            required: "Please enter the page url.",
                            remote:"This url is already exist."
                        }
                    },
                    // set this class to error-labels to indicate valid fields
                    success: function(label) {
                        // set &nbsp; as text for IE
                        label.hide();
                    }
                });

            });

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
                    <li> <a href="<?php echo base_url(); ?>backend/forum-categories">Manage Forum Category</a><span class="divider">/</span> </li>
                    <li> <a href="javascript:void(0);">Add Forum Category</a> </li>
                </ul>
            </div>
            <div class="row-fluid sortable"> 
                <!--[sortable header start]-->
                <div class="box span12">
                    <div class="box-header well">
                        <h2><i class=""></i>Add Forum Category</h2>
                        <div class="box-icon">
                            <a title="Manage Forum Category" class="btn btn-plus btn-round" href="<?php echo base_url(); ?>backend/forum-categories"><i class="icon-arrow-left"></i></a>
                        </div>

                    </div>
                    <br >
                    <!--[sortable body]-->
                    <div class="box-content">
                        <!--<form name="frm_currency" id="frm_currency" action="<?php echo base_url(); ?>backend/forum-category-edit/<?php echo(isset($arr_froum_categories_info['category_id'])) ? $arr_froum_categories_info['category_id'] : ''; ?>" method="post" >-->
                        <form name="frm_currency" id="frm_currency" action="<?php echo base_url(); ?>backend/forum-add-category" method="post" >
                            <input type="hidden" name="category_id" id="category_id" value="<?php echo(isset($arr_froum_categories_info['category_id'])) ? $arr_froum_categories_info['category_id'] : ''; ?>">
                            <div class="control-group">
                                <label class="control-label" for="subject">Category Name <sup style="color: red;">*</sup></label>
                                <div class="controls">
                                    <input type="text" dir="ltr" style="margin-left:200px; margin-top:-28px" class="FETextInput" name="category_name" value="<?php echo isset($arr_froum_categories_info['category_name']); ?>" id="category_name" size="1000"/>
                                </div>
                            </div>
                            <?php /*
                              <div class="control-group">
                              <label class="control-label" for="parent_id">Parent Category </label>
                              <div class="controls">
                              <select id="parent_id" name="parent_id" class="FETextInput" style="margin-left:200px; margin-top:-28px">
                              <option value="0" >Select Parent Category</option>
                              <?php
                              foreach ($arr_froum_categories_list as $arr_categories) {
                              if ($arr_froum_categories_info['category_id'] != $arr_categories['category_id']) {
                              ?>
                              <option value="<?php echo $arr_categories['category_id']; ?>" <?php echo $currency_status = ($arr_froum_categories_info['parent_id'] == $arr_categories['category_id']) ? 'selected' : '' ?>><?php echo $arr_categories['category_name']; ?></option>
                              <?php }
                              }
                              ?>
                              </select>
                              </div>
                              </div>
                             */
                            ?>

                            <div class="control-group">
                                <label class="control-label" for="subject">Page title </label>
                                <div class="controls">
                                    <input type="text" dir="ltr" style="margin-left:200px; margin-top:-28px" class="FETextInput" name="page_title" value="<?php echo isset($arr_froum_categories_info['page_title']); ?>" id="page_title" size="1000"/>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="subject">Page Keywords </label>
                                <div class="controls">
                                    <textarea  dir="ltr" style="margin-left:200px; margin-top:-28px" class="FETextInput" name="page_keywords"  id="page_keywords" size="1000" ><?php echo isset($arr_froum_categories_info['page_keywords']); ?> </textarea>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="subject">Page Description </label>
                                <div class="controls">
                                    <textarea  dir="ltr" style="margin-left:200px; margin-top:-28px" class="FETextInput" name="page_description"  id="page_description" size="1000" ><?php echo isset($arr_froum_categories_info['page_description']); ?></textarea> 
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="subject">Page Url <sup style="color: red;">*</sup></label>
                                <div class="controls">
                                    <input type="text" dir="ltr" style="margin-left:200px; margin-top:-28px" class="FETextInput" name="page_url" value="<?php echo isset($arr_froum_categories_info['page_url']); ?>" id="page_url" />
                                    <input type="hidden" dir="ltr" style="margin-left:200px; margin-top:-28px" class="FETextInput" name="page_url_old" value="<?php echo isset($arr_froum_categories_info['page_url']); ?>" id="page_url_old" />
                                </div>
                            </div>


                            <div class="form-actions">
                                <button type="submit" name="btnSubmit" class="btn btn-primary" value="Save changes">Save changes</button>
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
