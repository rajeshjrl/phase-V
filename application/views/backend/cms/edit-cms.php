<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo (isset($title)) ? $title : $global['site_title']; ?></title>
        <?php $this->load->view('backend/sections/header'); ?>
        <style>
            .error {
                color: #BD4247;
                /*margin-left: 120px;*/
                width: 210px;
            }
            .FETextInput{
                margin-left: 120px;
                margin-top: -28px;
            }
        </style>
        <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>media/backend/js/jquery.validate.min.js"></script>
        <link href="<?php echo base_url(); ?>media/backend/css/jquery.cleditor.css" rel='stylesheet'>
        <script src="<?php echo base_url(); ?>media/backend/js/jquery.cleditor.min.js"></script>
        <script src="<?php echo base_url(); ?>media/backend/js/jquery.cleditor.extimage.js"></script>
    </head>
    <body>
        <?php $this->load->view('backend/sections/top-nav.php'); ?>
        <?php $this->load->view('backend/sections/leftmenu.php'); ?>
        <div id="content" class="span10">
            <!--[breadcrumb]-->
            <div>
                <ul class="breadcrumb">
                    <li> <a href="<?php echo base_url(); ?>backend/dashboard">Dashboard</a> <span class="divider">/</span> </li>
                    <li> <a href="<?php echo base_url(); ?>backend/cms">Manage CMS</a> <span class="divider">/</span></li>                    
                    <li> Edit Cms Page </li>
                </ul>
            </div>
            <div class="row-fluid sortable"> 
                <!--[sortable header start]-->
                <div class="box span12">
                    <div class="box-header well">
                        <h2><i class=""></i>Edit Cms Page </h2>
                        <div class="box-icon">
                            <a title="Manage CMS" class="btn btn-plus btn-round" href="<?php echo base_url(); ?>backend/cms"><i class="icon-arrow-left"></i></a>
                        </div>
                    </div>
                    <br >
                    <!--[sortable body]-->
                    <div class="box-content">
                        <form class="form-horizontal" name="edit_cms_form" id="edit_cms_form" action="<?php echo base_url(); ?>backend/cms/edit-cms/<?php echo $arr_cms_details[0]['cms_id']; ?>" method="post">
                            <fieldset>
                                <legend> CMS Page Details (* Required) </legend>

                                <div class="control-group">
                                    <label class="control-label">CMS Page Title *</label>
                                    <div class="controls">
                                        <input type="text" maxlength="20" name="cms_page_title" id="cms_page_title" value="<?php echo $arr_cms_details[0]['page_title']; ?>">
                                    </div>
                                </div>   

                                <div class="control-group">
                                    <label class="control-label" for="textarea2">Cms Page Content</label>    
                                    <div class="controls">
                                        <textarea class="cleditor" id="content" name="content" ><?php echo $arr_cms_details[0]['page_content']; ?></textarea>
                                    </div>
                                </div>


                                <div class="control-group">
                                    <label class="control-label">Language</label>
                                    <div class="controls">
                                        <input type="text" readonly="readonly" name="lang_name" id="lang_name" value="<?php echo $arr_cms_details[0]['lang_name']; ?>" style="width:80px;" /> 
                                    </div>
                                </div>

                                <legend> Meta Details</legend>

                                <div class="control-group">
                                    <label class="control-label">Page SEO Title *</label>
                                    <div class="controls">
                                        <textarea name="cms_page_seo_title" id="cms_page_seo_title" rows="5" cols="20" style=" width: 350px;"><?php echo $arr_cms_details[0]['page_seo_title']; ?></textarea>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Meta Keywords *</label>
                                    <div class="controls">
                                        <textarea name="cms_page_meta_keywords" id="cms_page_meta_keywords" rows="5" cols="20"  style=" width: 350px;"><?php echo $arr_cms_details[0]['page_meta_keywords']; ?></textarea> 
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Meta Description *</label>
                                    <div class="controls">
                                        <textarea name="cms_page_meta_description" id="cms_page_meta_description" rows="5" cols="20"  style=" width: 350px;"><?php echo $arr_cms_details[0]['page_meta_description']; ?></textarea>                        			 
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" name="submit_button" id="submit_button" class="btn btn-primary" value="Save Changes">Save Changes</button>
                                    <input type="hidden" name="cms_id" id="cms_id" value="<?php echo $arr_cms_details[0]['cms_id']; ?>" >
                                    <button type="reset" name="cancel" class="btn" onClick="window.top.location = '<?php echo base_url(); ?>backend/cms';">Cancel</button>
                                </div>

                            </fieldset>
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

<script type="text/javascript" language="javascript">
    /* add admin Js */
    jQuery(document).ready(function() {
	
        jQuery("#edit_cms_form").validate({
		
            errorElement:'div',
		
            rules: {
                cms_page_title: {
                    required: true,
                    maxlength:20
                    
                },
                status: {
                    required: true
                },
                cms_page_meta_keywords:{
                    required:true
                },
                cms_page_meta_description:{
                    required:true
                },
                cms_page_meta_content:{
                    required:true
                }
            },
            messages: {
                cms_page_title:{
                    required:"Please enter cms page title.",
                    maxlength:"Please enter text only,up to 20 characters"
                },
                status:{
                    required:"Please select cms page status."
                },
                cms_page_meta_keywords:{
                    required:"Please mention page meta keywords."
                },
                cms_page_meta_description:{
                    required:"Please mention page meta description."
                },
                cms_page_meta_content:{
                    required:"Please mention page meta content."
                }
            }		
        });

        jQuery(".cleditor").cleditor();
        $.cleditor.buttons.image.uploadUrl = '<?php echo base_url(); ?>upload-image.php';
    });
</script>   

</html>
