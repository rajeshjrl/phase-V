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
	
                /*jQuery("#frm_add_payment_method").validate({
                    errorElement:'label',
                    rules: {                        
                        method_url:{
                            required: true,
                            remote:{
                                url:"<?php echo base_url(); ?>backend/payment-unique-uri",
                                data:{method_url_old:jQuery("#method_url_old").val()}
                            }
                        }
                    },
                    messages: {                        
                        method_url:{
                            required: "Please enter the method url.",
                            remote:"This url is already exist."
                        }
                    },
                    // set this class to error-labels to indicate valid fields
                    success: function(label) {
                        // set &nbsp; as text for IE
                        label.hide();
                    }
                });*/

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
                    <li> <a href="<?php echo base_url(); ?>backend/payment-method/list">Manage Payment Method</a><span class="divider">/</span> </li>
                    <li> <a href="javascript:void(0);">Edit Payment Method</a> </li>
                </ul>
            </div>
            <div class="row-fluid sortable"> 
                <!--[sortable header start]-->
                <div class="box span12">
                    <div class="box-header well">
                        <h2><i class=""></i>Edit Payment Method</h2>
                        <div class="box-icon">
                            <a title="Manage Payment Method" class="btn btn-plus btn-round" href="<?php echo base_url(); ?>backend/payment-method/list"><i class="icon-arrow-left"></i></a>
                        </div>

                    </div>
                    <br >
                    <!--[sortable body]-->
                    <div class="box-content">
                        <form name="frm_add_payment_method" id="frm_add_payment_method" action="<?php echo base_url(); ?>backend/payment-method/edit/<?php echo $method_id; ?>" method="post" >
						<input type="hidden" name="method_id" id="method_id" value="<?php echo $method_id;?>" />
                            <div class="control-group">
                                <label class="control-label" for="subject">Method Name <sup style="color: red;">*</sup></label>
                                <div class="controls">
                                    <input type="text" required dir="ltr" style="margin-left:200px; margin-top:-28px" class="FETextInput" name="method_name" value="<?php echo $arr_payment_method_data['method_name']; ?>" id="method_name" size="1000"/>
                                </div>
                            </div>
							
							<div class="control-group">
                                <label class="control-label" for="subject">Method Description <sup style="color: red;">*</sup></label>
                                <div class="controls">
									<textarea type="text" required dir="ltr" style="margin-left:200px; margin-top:-28px;width:400px;height:75px;" class="FETextInput" name="method_description" value="" id="method_description"><?php echo $arr_payment_method_data['method_description']; ?></textarea>                                  
                                </div>
                            </div>
							
							<div class="control-group">
                                <label class="control-label" for="subject">Method Url <sup style="color: red;">*</sup></label>
                                <div class="controls">
                                    <input type="text" readonly dir="ltr" style="margin-left:200px; margin-top:-28px" class="FETextInput" name="method_url" value="<?php echo $arr_payment_method_data['method_url']; ?>" id="method_url" size="1000"/>
                                </div>
                            </div>
							
							<div class="control-group">
                            	<label class="control-label" for="parent_id">Risk Level</label>
								<div class="controls">
								<select required id="risk_level" name="risk_level" class="FETextInput" style="margin-left:200px; margin-top:-28px">
									<option value="">Select Risk level</option>
									<option value="low" <?php if($arr_payment_method_data['risk_level'] == 'low') echo 'selected'; ?>>low</option>
									<option value="medium" <?php if($arr_payment_method_data['risk_level'] == 'medium') echo 'selected'; ?>>medium</option>
									<option value="high" <?php if($arr_payment_method_data['risk_level'] == 'high') echo 'selected'; ?>>high</option>
								</select>
								</div>
                            </div>
                            
                            <div class="control-group">
                            	<label class="control-label" for="parent_id">Parent Payment Method </label>
								<div class="controls">
								<select id="parent_method_id" name="parent_method_id" class="FETextInput" style="margin-left:200px; margin-top:-28px">
									<option value="0" >Select Parent Category</option>
									<?php foreach ($arr_payment_method_info as $arr_categories) { ?>
										<?php if($arr_payment_method_data['parent_method_id']==$arr_categories['method_id']) { ?>
											<option selected="selected" value="<?php echo $arr_categories['method_id']; ?>"><?php echo $arr_categories['method_name']; ?></option>
										<?php } else { ?>
											<option value="<?php echo $arr_categories['method_id']; ?>"><?php echo $arr_categories['method_name']; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
								</div>
                            </div>
							  
							<div class="control-group">
                            	<label class="control-label" for="parent_id">Status</label>
                            	<div class="controls">
                            		<select id="status" name="status" class="FETextInput" style="margin-left:200px; margin-top:-28px">
                            			<option value="A" <?php if($arr_payment_method_data['status']=='A') echo 'selected';?>>Active</option>
										<option value="I" <?php if($arr_payment_method_data['status']=='I') echo 'selected';?>>Inactive</option>                              
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
