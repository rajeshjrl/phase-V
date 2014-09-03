<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $header['title'];?></title>
    <meta name="keywords" content="<?php echo $header['keywords'];?>">
	<meta name="description" content="<?php echo $header['description'];?>">
    
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
	}
	.topic-title{
		font-size:14px;
		font-weight:bold;
		padding:10px 15px;
		background:#d5d5d5;
		}
	.topic-title a{
		font-size:14px;
		font-weight:bold;
		text-decoration:none;
		}
	.topic-footer{
		font-size:12px;
		font-weight:bold;
		padding:5px;
		background:#f5f5f5;
		text-align:right;
		}
		.search-bar{
		float:right;
		}
		.search-bar input{font-style:italic;}
		.clearfix{clear:both;}
	</style>
</head>
<body>

<div id="container">

    <div class="h1">Welcome to Forum Module!
    
    <div class="search-bar">
    <form method="post" action="<?php echo base_url();?>forum"><input type="search" name="search" placeholder="Search forum topic"></form>
    </div>
    <div class="search-bar"><a href="<?php echo base_url();?>forum/add-forum-topic" class="btn btn-sm btn-success">Add new topic</a>&nbsp;&nbsp;</div>
    <span class="clearfix"></span>
</div>
    
    <div style="width:25%;display:inline-block;vertical-align:top;border-right:1px solid #dcdcdc;">
    <strong>&nbsp;Categories</strong>
    <ul><?php echo $category_tree;?></ul>
	</div>
    <div style="width:74%;display:inline-block;text-align:justify;">
    <?php foreach($forum_topics as $topic){?>
<div class="forum-row">
<div class="topic-title">
		<a  title="Click to read more" href="<?php echo base_url() . "forum/" . $topic["page_url"]; ?>"><?php echo $topic["topic_title"]; ?></a>
</div>
<article>
<?php echo $topic["topic_short_description"];?>
</article>
<div class="topic-footer">Posted on : <?php echo date("d<\s\up>S</\s\up> M Y h:i A", strtotime($topic["posted_on"])); ?></div>
</div><?php
	}
	?>
    
</div>

</div>

</body>
</html>