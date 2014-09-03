<?php
/* * making sure that array having only one record.** */
$arr_email_template_details = end($arr_email_template_details);
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
        <script type="text/javascript" src="<?php echo base_url(); ?>media/backend/js/libs/editor/required_files_ckedior/ckeditor.js"></script>
        <script src="<?php echo base_url(); ?>media/backend/js/libs/editor/required_files_ckedior/sample.js" type="text/javascript"></script>	
        <script type="text/javascript">      
            CKEDITOR.replace( 'desc',
            {
                filebrowserBrowseUrl :'<?php echo base_url(); ?>media/backend/js/libs/editor/required_files_ckedior/filemanager/browser/default/browser.html?Connector=<?php echo base_url(); ?>/js/admin/libs/editor/required_files_ckedior/filemanager/connectors/php/connector.php',
                filebrowserImageBrowseUrl : '<?php echo base_url(); ?>media/backend/js/libs/editor/required_files_ckedior/filemanager/browser/default/browser.html?Type=Image&amp;Connector=<?php echo base_url(); ?>/js/admin/libs/editor/required_files_ckedior/filemanager/connectors/php/connector.php',
                filebrowserFlashBrowseUrl :'<?php echo base_url(); ?>media/backend/js/libs/editor/required_files_ckedior/filemanager/browser/default/browser.html?Type=Flash&amp;Connector=<?php echo base_url(); ?>/js/admin/libs/editor/required_files_ckedior/filemanager/connectors/php/connector.php'}
        );
            // here inserting text to ckeditor after double click.
            function insertText(obj) {
                newtext = obj.value;
                CKEDITOR.instances['textContent'].insertText(newtext);
            };
            //   CKEDITOR.instances.desc.insertText(newtext);
            //ckeditor.execCommand("ckInsertContent",false,);

        </script>
        <script type="text/javascript" language="javascript">

            $(document).ready(function(){
	
	
                jQuery("#frm_email_template").validate({
                    errorElement:'label',
                    rules: {
                        input_subject:{
                            required: true
                        },
                        text_content:{
                            required: true
                        }
                    },
                    messages: {
                        input_subject:{
                            required: "Please enter the email template subject."
                        },
                        text_content:{
                            required: "Please enter the email template content."
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
                    <li> <a href="<?php echo base_url(); ?>backend/email-template/list">Manage Email Template</a> <span class="divider">/</span></li>
                    <li> Update Email Template </li>
                </ul>
            </div>

            <div class="row-fluid sortable"> 
                <!--[sortable header start]-->
                <div class="box span12">
                    <div class="box-header well">
                        <h2><i class=""></i>Update Email Template</h2>
                        <div class="box-icon">
                            <a title="Manage Email Template" class="btn btn-plus btn-round" href="<?php echo base_url(); ?>backend/email-template/list"><i class="icon-arrow-left"></i></a>
                        </div>
                    </div>
                    <br >
                    <!--[sortable body]-->
                    <div class="box-content">
                        <form name="frm_email_template" id="frm_email_template" action="<?php echo base_url(); ?>backend/edit-email-template/<?php echo(isset($email_template_id)) ? $email_template_id : ''; ?>" method="POST" >
                            <input type="hidden" name="email_template_hidden_id" id="email_template_hidden_id" value="<?php echo(isset($email_template_id)) ? $email_template_id : ''; ?>">
                            <div class="control-group">
                                <label class="control-label" for="title">Email Template Title <sup style="color: red;">*</sup></label>
                                <div class="controls">
                                    <input type="text" dir="ltr" disabled="disabled" style="margin-left:200px; margin-top:-28px" class="FETextInput" name="inputTitle" value="<?php echo ucwords(str_replace("-", " ", $arr_email_template_details['email_template_title'])); ?>" id="inputTitle" size="100"   />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="subject">Email Template Subject <sup style="color: red;">*</sup></label>
                                <div class="controls">
                                    <input type="text" dir="ltr" style="margin-left:200px; margin-top:-28px" class="FETextInput" name="input_subject" value="<?php echo str_replace("\n", "", $arr_email_template_details['email_template_subject']); ?>" id="input_subject" size="1000"   />

                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="content">Email Template Content </label>
                                <div class="controls">
                                    <textarea dir="ltr" class="ckeditor"  style="width:100%;" class="FETextInput" name="text_content" id="text_content" ><?php echo stripcslashes($arr_email_template_details['email_template_content']); ?></textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="content">Email Template Content Macros</label>
                                <div class="controls">
                                    <select style="width:100%;"  class="combobox"  multiple ondblclick="insertText(this)" style="min-height:80px;">
                                        <option value="||USER_NAME||">User Name ||USER_NAME||</option> 
                                        <option value="||QUICK_GUIDE||">Quick start guide ||QUICK_GUIDE||</option> 

                                    </select>
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