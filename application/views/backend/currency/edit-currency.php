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
	
                jQuery("#frm_currency").validate({
                    errorElement:'label',
                    rules: {
                        currency_name:{
                            required: true
                        },
                        currency_code:{
                            required: true
                        },
                        currency_exchange_code:{
                            required: true
                        },
                        currency_status:{
                            required: true
                        }
                    },
                    messages: {
                        currency_name:{
                            required: "Please enter the currency name."
                        },
                        currency_code:{
                            required: "Please enter the currency code."
                        },
                        currency_exchange_code:{
                            required: "Please enter the currency exchange code."
                        },
                        currency_status:{
                            required: "Please select the currency status."
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
                    <li> <a href="<?php echo base_url(); ?>backend/currency/list">Manage Currency</a><span class="divider">/</span> </li>
                    <li> <a href="javascript:void(0);">Edit Currency</a> </li>
                </ul>
            </div>
            <div class="row-fluid sortable"> 
                <!--[sortable header start]-->
                <div class="box span12">
                    <div class="box-header well">
                        <h2><i class=""></i>Update Currency</h2>
                        <div class="box-icon">
                            <a title="Manage Currency" class="btn btn-plus btn-round" href="<?php echo base_url(); ?>backend/currency/list"><i class="icon-arrow-left"></i></a>
                        </div>

                    </div>
                    <br >
                    <!--[sortable body]-->
                    <div class="box-content">
                        <form name="frm_currency" id="frm_currency" action="<?php echo base_url(); ?>backend/currency/edit-currency" method="post" >
                            <input type="hidden" name="currency_id" id="currency_id" value="<?php echo(isset($arr_currency_details['currency_id'])) ? $arr_currency_details['currency_id'] : ''; ?>">
                            <div class="control-group">
                                <label class="control-label" for="subject">Currency Name <sup style="color: red;">*</sup></label>
                                <div class="controls">
                                    <input type="text" dir="ltr" style="margin-left:200px; margin-top:-28px" class="FETextInput" name="currency_name" value="<?php echo $arr_currency_details['currency_name']; ?>" id="currency_name" size="1000"/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="content">Currency code </label>
                                <div class="controls">
                                    <input type="text" dir="ltr" style="margin-left:200px; margin-top:-28px" class="FETextInput" name="currency_code" value="<?php echo $arr_currency_details['currency_code']; ?>" id="currency_code" size="1000"   />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="content">Currency Exchange code </label>
                                <div class="controls">
                                    <input type="text" dir="ltr" style="margin-left:200px; margin-top:-28px" class="FETextInput" name="currency_exchange_code" value="<?php echo $arr_currency_details['currency_exchange_code']; ?>" id="currency_exchange_code" size="1000"   />
                                </div>
                            </div>
                            <div class="control-group">                                
                                <label class="control-label" for="content">Status </label>
                                <div class="controls">
                                    <select id="currency_status" name="currency_status" class="FETextInput" style="margin-top:-50px;margin-left:200px;">
                                        <option value="A" <?php echo $currency_status = ($arr_currency_details['status'] == 'A') ? 'selected' : '' ?>>Active</option>
                                        <option value="I" <?php echo $currency_status = ($arr_currency_details['status'] == 'I') ? 'selected' : '' ?>>InActive</option>
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