<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo (isset($title)) ? $title : $global['site_title']; ?></title>
        <?php $this->load->view('backend/sections/header'); ?>
        <style>
            .error {
                color: #BD4247;
                margin-left: 140px;
                width: 210px;
            }
            .FETextInput{
                margin-left: 120px;
                margin-top: -28px;
            }
        </style>
        <!-- validation js -->
        <script language="javascript" type="text/javascript" src="<?php echo base_url(); ?>media/backend/js/jquery.validate.min.js"></script>
        <script type="text/javascript" language="javascript">
            $(document).ready(function(){
                jQuery("#frmTestimonials").validate({
                    errorElement:'label',
                    rules: {
                        inputTestimonial:{
                            required: true,
                            minlength: 20
                        },
                        inputName:{
                            required: true
                        }
                    },
                    messages: {
                        inputTestimonial:{
                            required: "Please enter testimonial",
                            minlength: "Please enter at least 20 characters"
                        },
                        inputName:{
                            required: "Please enter name"
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
                    <li> <a href="<?php echo base_url(); ?>backend/dashboard">Dashboard</a> <span class="divider">/</span> </li>
                    <li> <a href="<?php echo base_url(); ?>backend/testimonial/list">Manage Testimonial</a> <span class="divider">/</span></li>
                    <li> <?php echo ((isset($edit_id) && $edit_id != "") ? "Update" : "Add"); ?> Testimonial </li>
                </ul>
            </div>

            <div class="row-fluid sortable"> 
                <!--[sortable header start]-->
                <div class="box span12">
                    <div class="box-header well">
                        <h2><i class=""></i><?php echo ((isset($edit_id) && $edit_id != "") ? "Update" : "Add"); ?> Testimonial</h2>
                        <div class="box-icon">
                            <a title="Manage Testimonial" class="btn btn-plus btn-round" href="<?php echo base_url(); ?>backend/testimonial/list"><i class="icon-arrow-left"></i></a>
                        </div>
                    </div>
                    <br >
                    <!--[sortable body]-->
                    <div class="box-content">
                        <form name="frmTestimonials" id="frmTestimonials" action="<?php echo base_url(); ?>backend/testimonial/add" method="POST" >

                            <div class="control-group">
                                <label class="control-label" for="inputQuestion">Testimonial<sup class="mandatory">*</sup></label>
                                <div class="controls">
                                    <textarea  style="margin-left:100px; margin-top:-28px" class="FETextInput" name="inputTestimonial" size="80"><?php
        if (isset($arr_testimonial['testimonial'])) {
            echo stripslashes($arr_testimonial['testimonial']);
        }
        ?></textarea>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="inputAnswer">Name<sup class="mandatory">*</sup></label>
                                <div class="controls">
                                    <input type="text" dir="ltr" style="margin-left:100px; margin-top:-28px" class="FETextInput" name="inputName" value="<?php
                                        if (isset($arr_testimonial['name'])) {
                                            echo $arr_testimonial['name'];
                                        }
        ?>" size="80"   />
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" name="btnSubmit" class="btn btn-primary" value="Save changes">Save changes</button>
                                <input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>">
                            </div>
                        </FORM>
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
