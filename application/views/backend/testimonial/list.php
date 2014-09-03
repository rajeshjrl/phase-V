<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo (isset($title)) ? $title : $global['site_title']; ?></title>
        <?php $this->load->view('backend/sections/header'); ?>
        <script src="<?php echo base_url(); ?>media/backend/js/jquery.dataTables.min.js"></script> 
        <script src="<?php echo base_url(); ?>media/backend/js/bootstrap-tab.js"></script>
        <!-- library for advanced tooltip -->
        <script src="<?php echo base_url(); ?>media/backend/js/bootstrap-tooltip.js"></script>
        <script src="<?php echo base_url(); ?>media/backend/js/charisma.js"></script> 
        <script src="<?php echo base_url(); ?>media/backend/js/select-all-delete.js"></script> 
    </head>
    <body>
        <?php $this->load->view('backend/sections/top-nav.php'); ?>
        <?php $this->load->view('backend/sections/leftmenu.php'); ?>

        <div id="content" class="span10">
            <!--[breadcrumb]-->
            <div>
                <ul class="breadcrumb">
                    <li> <a href="<?php echo base_url(); ?>backend/dashboard">Dashboard</a> <span class="divider">/</span> </li>
                    <li> Manage Testimonial</li>
                </ul>
            </div>

            <!--[message box]-->
            <?php
            $msg = $this->session->userdata('msg');
            ?>
            <!--[message box]-->
            <?php if ($msg != '') { ?>
                <div class="msg_box alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" id="msg_close" name="msg_close">×</button>
                    <?php
                    echo $msg;
                    $this->session->unset_userdata('msg');
                    ?> 
                </div>
                <?php
            }
            ?>  
            <div class="row-fluid sortable"> 
                <!--[sortable header start]-->
                <div class="box span12">
                    <div class="box-header well">
                        <h2><i class=""></i>Testimonial Management</h2>
                        <div class="box-icon">
                            <a title="Add new Testimonial" class="btn btn-plus btn-round" href="<?php echo base_url(); ?>backend/testimonial/add"><i class="icon-plus"></i></a>
                        </div>
                    </div>
                    <br >
                    <form name="frmAdminUsers" id="frmAdminUsers" action="<?php echo base_url(); ?>backend/testimonial/list" method="post">
                        <!--[sortable body]-->
                        <div class="box-content">
                            <table  class="table table-striped table-bordered bootstrap-datatable datatable">
                                <thead>
                                <th width="7%" class="workcap">
                                <center>Select <br><input type="checkbox" name="checkall" id="checkall"  class="select_all_button_class" value="select all" /></center>

<!--Select<br><input type="checkbox" id="chkAll">-->
                                </th>
                                <th width="43%" class="workcap">Testimonial</th>
                                <th width="15%" class="workcap">Name</th>
                                <th width="10%" class="workcap">Status</th>
                                <th width="10%" class="workcap">Added By</th>
                                <th width="20%" class="workcap" align="center">Action</th>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($arr_tetimonials as $tetimonials) {
                                        ?>
                                        <tr>
                                         <!-- <td class="worktd" align="left"><center><input value="<?php echo $tetimonials['testimonial_id']; ?>" class="chkselect" type="checkbox"></center></td>-->
                                            <td class="worktd" align="left">
                                    <center><input name="checkbox[]" class="case" type="checkbox" id="checkbox[]" value="<?php echo $tetimonials['testimonial_id']; ?>" /></center>
                                    </td>
                                    <td class="worktd"  align="left"><?php echo stripslashes($tetimonials['testimonial']); ?></td>
                                    <td class="worktd"  align="left"><?php echo stripslashes($tetimonials['name']); ?></td>
                                    <td class="worktd"  align="left">

                                        <?php
                                        switch ($tetimonials['status']) {
                                            case 'Active':
                                                $class = 'label-success';
                                                $status = $tetimonials['status'];
                                                $status_to_change = 'Inactive';
                                                break;
                                            case 'Inactive':
                                                $class = 'label-warning';
                                                $status = $tetimonials['status'];
                                                $status_to_change = 'Active';
                                                break;
                                        }
                                        ?>		

                                        <div  id="activeDiv<?php echo $tetimonials['testimonial_id']; ?>" <?php if ($tetimonials['status'] == "Active") { ?> style="display:inline-block" <?php } else { ?> style="display:none;" <?php } ?>>
                                            <a class="label label-success" title="Click to Change Status" onClick="changeStatus('<?php echo $tetimonials['testimonial_id']; ?>','Inactive');" href="javascript:void(0);" id="status_<?php echo $tetimonials['testimonial_id']; ?>">Active</a>
                                        </div>

                                        <div id="inActiveDiv<?php echo $tetimonials['testimonial_id']; ?>" <?php if ($tetimonials['status'] == "Inactive") { ?> style="display:inline-block" <?php } else { ?> style="display:none;" <?php } ?>>
                                            <a class="label label-warning" title="Click to Change Status" onClick="changeStatus('<?php echo $tetimonials['testimonial_id']; ?>','Active');" href="javascript:void(0);" id="status_<?php echo $tetimonials['testimonial_id']; ?>">Inactive</a>
                                        </div>
                                    </td>

                                    <td class="worktd"  align="left"><?php echo $tetimonials['added_by']; ?></td>

                                    <td class="worktd">

                                        <a class="btn btn-info" href="<?php echo base_url(); ?>backend/testimonial/add/<?php echo base64_encode($tetimonials['testimonial_id']); ?>">
                                            <i class="icon-edit icon-white"></i>Edit</a> 
                                    </td>
                                    <?php
                                }
                                ?>
                                </tbody>
                                <tfoot>
                                <th colspan="6"><input type="submit" id="btn_delete_all" name="btn_delete_all" class="btn btn-danger" onClick="return deleteconfirm();"  value="Delete Selected"></th>
                                </tfoot>
                            </table>
                        </div>
                        <!--[sortable body]--> 
                    </form>
                </div>
            </div>

            <!--[sortable table end]--> 

            <!--[include footer]-->
        </div><!--/#content.span10-->

    </div><!--/fluid-row-->
    <?php $this->load->view('backend/sections/footer.php'); ?>
</div><!--/.fluid-container-->
<script type="text/javascript">

    function changeStatus(testimonial_id,status)
    {
        var objParams=new Object();
        objParams.testimonial_id=testimonial_id;
        objParams.status=status;
        jQuery.post("<?php echo base_url(); ?>backend/testimonial/change-status",objParams,function(msg){
            if(msg.error=="1")
            {
                alert(msg.errorMessage);
            }
            else
            {
                if(status=="Inactive")
                {
                    $("#inActiveDiv"+testimonial_id).css('display','inline-block');
                    $("#activeDiv"+testimonial_id).css('display','none');
				
                }
                else
                {
                    $("#activeDiv"+testimonial_id).css('display','inline-block');
                    $("#inActiveDiv"+testimonial_id).css('display','none');
                }
			
                /* alert("Your request has been completed successfully!"); */
                /* location.href=location.href; */
            }
        },"json");
    }	
</script>
</body>
</html>