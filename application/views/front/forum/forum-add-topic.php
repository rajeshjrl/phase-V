<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $header['title'];?></title>
     <meta name="keywords" content="<?php echo $header['keywords'];?>">
	<meta name="description" content="<?php echo $header['description'];?>">
     <script>
            var SITE_PATH = '<?php echo base_url(); ?>';
 </script>
<script src="<?php echo base_url();?>media/front/js/jquery-1.7.2.min.js"></script>
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="<?php echo base_url();?>media/front/js/forum-add-topic.js"></script>
<script src="<?php echo base_url();?>media/front/js/jquery.cleditor.min.js"></script>

<link href="<?php echo base_url(); ?>media/front/css/jquery.cleditor.css" type="text/css" rel="stylesheet">
 
<style type="text/css">
	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }
	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}
	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}
	.h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}
	.forum-row{
	background:#f7f7f7;
	margin:15px 5px;
	}
	.forum-row article{
	padding:10px 15px;
	text-align:justify;
	border:1px solid #D7D7D7;
	}
	.topic-title{
		font-size:20px;
		font-weight:bold;
		padding:10px 15px;
		background:#999999;
		color:#fefefe;
		}
	
	.topic-footer{
		font-size:12px;
		font-weight:bold;
		padding:5px;
		background:#222222;
		text-align:right;
		}
		.search-bar{
		float:right;
		}
		.search-bar input{font-style:italic;}
		.clearfix{clear:both;}
		.control-group{padding:10px 15px;
	text-align:justify;}
	.control-group textarea{resize:none;width:100%;height:50px;}
	.comment-title{
		font-size:14px;
		font-weight:bold;
		padding:10px 15px;
		background:#eeeeee;
		}
		.comment-footer{
		padding:5px;
		}
		.btnPostComment{border-radius:3px;background:#0CF;boder:1px solid #0ce;padding:5px;}
		.text-danger{font-size:12px;color:#900;font-weight:bold;}
		.well{padding:5px 15px;background:#f5f5f5;margin:5px;border-radius:5px;border:1px solid #d7d7d7;}
		.well p {text-align:justify;}
		.well .pull-right{
			font-size:12px;font-weight:bold;
			float:right;
			
			}
		.well .pull-left{
			font-size:12px;font-weight:bold;
			float:left;
			}
			.clearfix{clear:both;}
	</style>
</head>
<body>

<div id="container">
	<div class="h1">Add new forum topic!
    <div class="search-bar">
    <form method="post" action="<?php echo base_url();?>forum"><input type="search" name="search" placeholder="Search forum topic"></form>
    </div>
    <span class="clearfix"></span>
</div>
    <div style="width:25%;display:inline-block;vertical-align:top;border-right:1px solid #dcdcdc;">
    <strong>&nbsp;Categories</strong>
    <ul><?php echo $category_tree;?></ul>
	</div>
    <div style="width:70%;display:inline-block;">
   <form class="form" name="frmForumTopic" id="frmForumTopic" method="post">
                                                <legend>Add New Topic</legend>
                                                <div class="control-group">
                                                    <div class="controls">
                                                       <input type="text" style="width:80%" placeholder="Enter title here" id="inputForumTitle" name="inputForumTitle"><br>
<br>

                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <div class="controls">
                                                        <textarea style="width:80%" name="inputForumTopicShortDescription" id="inputForumTopicShortDescription" placeholder="Enter topic short description here"></textarea><br>
                                                        <br>

                                                    </div>
                                                    <div class="control-group">
                                                    <div class="controls">
                                                        <textarea style="width:100%" name="inputForumTopicDescription" id="inputForumTopicDescription"></textarea><br>
                                                        <br>

                                                    </div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <div class="controls">
                                                    <label style="width:11%;text-align:right;" for="inputCategory">Select Category</label>
                                                       <?php
							echo '<select id="inputCategory" name="inputCategory" style="width:69%">' . $str_categories_menu_select . "</select>";
														?><br><br>


                                                    </div>
                                                </div>
                                                
                                                <div class="control-group">
                                                    <div class="controls">
                                                       <textarea style="width:80%" placeholder="Enter topic meta keywords" id="inputForumTopicMetaKeywords" name="inputForumTopicMetaKeywords"></textarea>
                                                       <br>
                                                       <br>
                                                </div>
                                                </div>
                                                <div class="control-group">
                                                    <div class="controls">
                                                       <textarea style="width:80%" placeholder="Enter topic meta description" id="inputForumTopicMetaDescription" name="inputForumTopicMetaDescription"></textarea><br>
<br>

                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <div class="controls">
                                                       <input type="text" style="width:80%" placeholder="Enter topic page title" id="inputForumTopicPageTitle" name="inputForumTopicPageTitle"><br>
<br>

                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <div class="controls">
                                                        <button class="btn-sm btn-primary" id="btnAddTopic" type="button">Post your topic</button>
                                                    </div>
                                                </div>



                                            </form>
</div>

</div>

</body>
</html>