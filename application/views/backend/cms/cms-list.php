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
                    <li>Manage CMS</li>
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
                        <h2><i class=""></i>CMS Management</h2>              
                    </div>
                    <br >
                    <div class="box-content">
                        <table class="table table-striped table-bordered bootstrap-datatable datatable">
                            <thead>
                                <tr>
                                        <!--<th># News Category Id</th>-->                        
                                    <th>Page Title</th>
                                    <th>Page Alias</th>
                                    <th>Language</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>   
                            <tbody>

                                <?php
                                if (!empty($get_cms_list)) {
                                    foreach ($get_cms_list as $key => $value) {
                                        #@Variable Declaration:-
                                        $cms_id = $value['cms_id'];
                                        $cms_page_lag_id = $value['lang_id'];
                                        $cms_page_alias = $value['page_alias'];
                                        $cms_page_title = $value['page_title'];
                                        $cms_page_content = $value['page_content'];
                                        $cms_page_status = $value['status'];
                                        $cms_page_lang_name = $value['lang_name'];
                                        ?>						 
                                        <tr>
                                            <td><?php echo $cms_page_title; ?></td>
                                            <td><?php echo $cms_page_alias; ?></td>							
                                            <td><?php echo $cms_page_lang_name; ?></td>

                                            <td class="center">
                                                <?php if ($cms_page_status == 'Published') { ?>
                                                    <span class="label label-success">Published</span>
                                                <?php } else { ?>
                                                    <span class="label label-important">Unpublished</span>
                                                <?php } ?>
                                            </td>

                                            <td class="center">
                                                <a class="btn btn-info" href="<?php echo base_url(); ?>backend/cms/edit-cms/<?php echo $cms_id; ?>"><i class="icon-edit icon-white"></i>Edit</a>                                                
                                            </td>
                                        </tr>
                                        <?php
                                    }#end:foreach;
                                }#end:if case;			
                                ?>

                            </tbody>
                        </table>            
                    </div>
                </div>
            </div>

            <!--[sortable table end]--> 

            <!--[include footer]-->
        </div><!--/#content.span10-->

    </div><!--/fluid-row-->
    <?php $this->load->view('backend/sections/footer.php'); ?>
</div><!--/.fluid-container-->

</body>
</html>