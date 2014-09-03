
<div class="page_holder">
    <div class="page_inner">
        <div class="wallet_section forums">
            <div class="forums_header">
                <ul>
                    <?php if ($user_session['user_id'] != '') { ?>
                        <li><a href="<?php echo base_url(); ?>get-user-feeds"><span class="feed_home">&nbsp;</span><?php echo lang('my_feeds'); ?></a></li>
                    <?php } else { ?>                        
                        <li><a href="javascript:void(0);" title="login first"><span class="feed_home">&nbsp;</span><?php echo lang('my_feeds'); ?></a></li>
                    <?php } ?>
                    <li><a href="<?php echo base_url(); ?>forum"><span class="feed_all"></span><?php echo lang('all_posted'); ?></a></li>
                </ul>
                <div class="search_forums">
                    <form method="post" action="<?php echo base_url(); ?>forum" name="frm_forum_search" id="frm_forum_search">
                        <input type="text" name="search" id="search" value="<? echo $posted_key = (isset($posted_key)) ? $posted_key : ''; ?>" placeholder="<?php echo lang('search'); ?>">
                    </form>
                </div>
            </div>
            <div class="forums_content">
                <div class="forum_left_content">
                    <div class="data">
                        <div class="forum_list">
                            <?php if ($user_session['user_id'] != '') { ?>
                                <div class="forums_posted" id="add_forum_topic_div">
                                    <div class="add_topic_in_forum">
                                        <input type="text" name="add_forum_topic" id="add_forum_topic" placeholder="<?php echo lang('start_a_new_topic'); ?>">
                                        <div class="two_displaying" style="display: none;">
                                            <input type="text" name="add_forum_topic_title" id="add_forum_topic_title" required placeholder="Start a new topic here..." >
                                            <input type="text" name="add_forum_topic_text" id="add_forum_topic_text" required placeholder="Body text...">                                    
                                        </div>
                                    </div>
                                    <div class="add_topic_in_forum_bottom">
                                        <select name="select_forum" id="select_forum" style="display: none;">
                                            <option value="" title="Select forum"><?php echo lang('select_forum_category'); ?></option>
                                            <?php foreach ($category_info_arr as $category_arr) { ?>
                                                <option value="<?php echo $category_arr['category_id']; ?>" title="<?php echo $category_arr['category_name']; ?>"><?php echo $category_arr['category_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <input type="button" name="add_forum_topic_btn" id="add_forum_topic_btn" value="Post topic"  style="display: none;" onclick="postForumTopic();">                                
                                    </div> 
                                </div>     
                            <?php } ?>
                            <?php
                            $j = 0;
                            if (count($forum_topics) > 0) {
                                foreach ($forum_topics as $forum_topic) {
                                    ?>
                                    <div class="forum_post" id="forum_post">
                                        <div class="user_image">
                                            <?php $forum_topic['profile_picture'] = (isset($forum_topic['profile_picture'])) ? $forum_topic['profile_picture'] : 'photo-45519.png'; ?>
                                            <img src="<?php echo base_url(); ?>media/front/images/profile-images/thumb/<?php echo $forum_topic['profile_picture']; ?>" alt="<?php echo 'user_name'; ?>" width="50px" height="50px" title="<?php echo $forum_topic['user_name']; ?>">
                                        </div>
                                        <div class="user_info">
                                            <div class="post_u_name"><?php echo $forum_topic['user_name']; ?></div>
                                            <div class="post_time"><?php echo date("d<\s\up>S</\s\up> M Y h:i A", strtotime($forum_topic['posted_on'])); ?></div>
                                            <span> in</span>
                                            <div class="post_discussion"><?php echo $forum_topic['category_name']; ?></div>
                                            <div class="post_social_links">
                                                <ul>                                                    
                                                    <li><span class="comment" title="total <?php echo count($forum_topic['comments']); ?> comments">&nbsp;</span><span class="count" id="comments_<?php echo $forum_topic['topic_id']; ?>" ><?php echo count($forum_topic['comments']); ?></span></li>
        <!--                                                    <li><span class="like">&nbsp;</span><span class="count">20</span></li>
                                                    <li><span class="view">&nbsp;</span></li>-->
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="forum_title" onclick="showTopicDescription(<?php echo $forum_topic['topic_id']; ?>)" id="topic_title">
                                            <h3><?php echo $forum_topic['topic_title'] = ($posted_key != '') ? highlightkeyword($forum_topic['topic_title'], $posted_key) : $forum_topic['topic_title']; ?></h3>
                                        </div>
                                        <div class="user_comments" <?php if (!isset($search_comment_flag)) { ?>style="display: none;"<?php } ?> id="user_comment_id_<?php echo $forum_topic['topic_id']; ?>">
                                            <div class="user_comment_data">
                                                <p><?php echo $forum_topic['topic_content'] = ($posted_key != '') ? highlightkeyword($forum_topic['topic_content'], $posted_key) : $forum_topic['topic_content']; ?></p>
                                            </div>
                                            <?php if ($user_session['user_id'] != '') { ?>
                                                <div class="total_comment" style="display: block;" id="total_comment_<?php echo $forum_topic['topic_id']; ?>" title="Total <?php echo count($forum_topic['comments']); ?> Comments"><div id="total_comment_count_<?php echo $forum_topic['topic_id']; ?>">Total <?php echo count($forum_topic['comments']); ?> Comments</div></div>
                                            <?php } ?>
                                            <?php
                                            if ($forum_topic['comments'] != '') {

                                                if (count($forum_topic['comments']) > 0) {
                                                    ?>
                                                    <div id="forun_uniqe_cmt_<?php echo $forum_topic['topic_id']; ?>">
                                                        <?php
                                                        for ($i = 0; $i < count($forum_topic['comments']); $i++) {

                                                            $forum_topic['comments'][$i]['c_profile_picture'] = (isset($forum_topic['comments'][$i]['c_profile_picture'])) ? $forum_topic['comments'][$i]['c_profile_picture'] : 'photo-45519.png';
                                                            ?>
                                                            <div class="user_post_comment" id="user_post_comments_<?php echo $forum_topic['comments'][$i]['comment_id']; ?>">
                                                                <div class="user_image"><img src="<?php echo base_url(); ?>media/front/images/profile-images/thumb/<?php echo $forum_topic['comments'][$i]['c_profile_picture']; ?>" alt="<?php echo 'user_name'; ?>" width="50px" height="50px" title="<?php echo $forum_topic['comments'][$i]['user_name']; ?>"></div>
                                                                <div class="user_info">
                                                                    <div class="post_u_name"><?php echo $forum_topic['comments'][$i]['user_name']; ?></div>
                                                                    <div class="post_time"><?php echo date("d<\s\up>S</\s\up> M Y h:i A", strtotime($forum_topic['comments'][$i]["comment_on"])); ?></div>                                                
                                                                    <div class="post_social_links">
                                                                        <!--                                                                        <ul>
                                                                                                                                                    <li><span class="info">&nbsp;</span></li>
                                                                                                                                                </ul>-->
                                                                    </div>
                                                                </div>
                                                                <div class="user_comment_data">
                                                                    <p>
                                                                        <?php echo $forum_topic['comments'][$i]["comment"] = ($posted_key != '') ? highlightkeyword($forum_topic['comments'][$i]["comment"], $posted_key) : nl2br(stripslashes($forum_topic['comments'][$i]["comment"])); ?>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>     
                                                <?php } else { ?>
                                                    <div id="forun_uniqe_cmt_<?php echo $forum_topic['topic_id']; ?>"></div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <?php if ($user_session['user_id'] != '') { ?>
                                                <form name="post_comment" id="post_comment" method="" action="">
                                                    <div class="forums_posted" id="comment_<?php echo $forum_topic['topic_id']; ?>" style="display: block;">
                                                        <input type="text" id="msg_comment_<?php echo $forum_topic['topic_id']; ?>" required  name="msg_comment" value="" placeholder="Reply...">
                                                        <input type="hidden" name="topic_id" id="topic_id" value="<?php echo $forum_topic['topic_id']; ?>">                                                   
                                                        <input type="button" name="hit_comment"  id="hit_comment" value="Hit comment" title="Hit comment" class="btn_post" onclick="addComment(<?php echo $forum_topic['topic_id']; ?>) ">
                                                    </div>
                                                </form>
                                            <?php } ?>
                                        </div>                                        
                                    </div>                                                                
                                    <?php
                                    $j++;
                                }
                            } else {
                                ?>
                                <div class="forum_post">
                                    <?php
                                    if (isset($search_flag)) {
                                        echo '<center style="font-size: 14px;font-weight: bold";>No result found.</center>';
                                        ?>                                       
                                        <?php
                                    } else {
                                        echo '<center style="font-size: 14px;font-weight: bold";>No topic posted yet.</center>';
                                        ?>
                                    <?php } ?>
                                </div>
                            <?php }
                            ?>
                        </div>
                    </div>
                    <?php if (isset($total_topic_count) && ($total_topic_count > 2 )) { ?>
                        <div class="total_comment view_more" id="view_more_div" title="view more topics" onclick="view_more_topics()" style="display: block;" title="view more">
                            <?php
                            $count = intval(count($forum_topics));
                            $total_topic_count1 = $total_topic_count - $count;
                            ?>
                            <input type="button" name="view_more" id="view_more" value="<?php echo ($total_topic_count - count($forum_topics)); ?>">
                            <input type="hidden" name="total_topic_count" id="total_topic_count" value="<?php echo $total_topic_count; ?>">
                            <input type="hidden" name="first_topic_count" id="first_topic_count" value="<?php echo $first_topic_count; ?>">
                            <input type="hidden" name="sort_variable" id="sort_variable" value="<?php echo $sort_variable = ($sort_variable != '') ? $sort_variable : ''; ?>">
                            <input type="hidden" name="posted_key" id="posted_key" value="<?php echo $posted_key = ($posted_key != '') ? $posted_key : ''; ?>">
                        </div>
                    <?php } ?>                    
                </div>

                <div class="forum_right_content">
                    <div class="data">
                        <div class="head"><?php echo lang('forums'); ?></div>
                        <ul>
                            <li><a href="<?php echo base_url(); ?>advertise"><?php echo lang('post_a_trade_request'); ?></a></li>
                            <?php echo $category_tree; ?>
                        </ul>
                    </div>
                    <?php if ($user_session['user_id'] != '') { ?>
                        <div class="data">
                            <div class="head"><?php echo lang('forum_settings'); ?></div>
                            <ul>
                                <li><a href="<?php echo base_url(); ?>forum/change"><span class="profile_public">&nbsp;</span><?php echo lang('change_avatar_image'); ?></a></li>                                
                            </ul>
                        </div>
                    <?php } ?>
                    <div class="data online_user">
                        <div class="head"><span class="user_multy">&nbsp;</span><?php echo lang('online'); ?> <div class="total_comment"> <?php echo count($arr_online_user); ?> </div></div>
                        <?php
                        if (is_array($arr_online_user)) {
                            foreach ($arr_online_user as $online_user) {

                                $file_dir = $absolutePath . 'media/front/images/profile-images/thumb/' . $online_user['profile_picture'];

                                if (is_file($file_dir)) {
                                    $online_user['profile_picture'] = $online_user['profile_picture'];
                                } else {
                                    $online_user['profile_picture'] = 'photo-45519.png';
                                }
                                ?>
                                <ul>
                                    <li><a href="<?php echo base_url(); ?>profile/<?php echo $online_user['user_name']; ?>">
                                            <div class="user_image">
                                                <img src="<?php echo base_url(); ?>media/front/images/profile-images/thumb/<?php echo $online_user['profile_picture']; ?>" alt="user_name" width="25px" height="25px" title="<?php echo $online_user['user_name']; ?>" >
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
            </div>       	
        </div>            
    </div>
</div>
</section>

<?php

function highlightkeyword($str, $search) {
    $highlightcolor = "yellow";
    $occurrences = substr_count(strtolower($str), strtolower($search));
    $newstring = $str;
    $match = array();

    for ($i = 0; $i < $occurrences; $i++) {
        $match[$i] = stripos($str, $search, $i);
        $match[$i] = substr($str, $match[$i], strlen($search));
        $newstring = str_replace($match[$i], '[#]' . $match[$i] . '[@]', strip_tags($newstring));
    }
    $newstring = str_replace('[#]', '<span style="background-color: ' . $highlightcolor . ';">', $newstring);
    $newstring = str_replace('[@]', '</span>', $newstring);
    return $newstring;
}
?>



<script type="text/javascript">

    function showTopicDescription(topic_id){         
        $("#comment_data_"+topic_id).toggle();    
        $("#user_comment_id_"+topic_id).toggle();                           
    }
            
    /* add forum topic textbox*/
    $("#add_forum_topic").click(function() {                
        $(".two_displaying").show();
        $("#add_forum_topic_btn").show();
        $("#select_forum").show();
        $("#add_forum_topic").hide();        
    });
            
    /*function to add comments*/
            
    function addComment(topic_id){
        
        var msg_comment = $("#msg_comment_"+topic_id).val();
                
        if((msg_comment =='')){
            alert('please enter your comment.');
            return false;
        }else if(msg_comment.length <= 5){
            alert('please enter more than 5 character.');
            return false;            
        }
                
        $.ajax({                           
            method:'post',
            url:"<?php echo base_url(); ?>forum/add-comments",            
            data:{'topic_id':topic_id,'msg_comment':msg_comment},
            success:function(response){   
                /*split the response array res[0] contains comment count and res[1] contain comment div to be append*/
                var res = response.split('||');  
               
                $("#comments_"+topic_id).html('<span class="count" id="comments_'+topic_id+'">'+res[0]+'</span>');   
                $("#total_comment_count_"+topic_id).html('<div id="total_comment_count_'+topic_id+'">Total '+res[0]+' Comments</div>'); 
                $('#forun_uniqe_cmt_'+topic_id).append(res[1]);                
                $('#msg_comment_'+topic_id).val('');                                                        
            }       
        });                          
    }               
    /*post Forum Topic*/
            
    function postForumTopic(){
                
        var category_id = $('#select_forum :selected').val();
        var category_name = $('#select_forum :selected').text();
        var topic_title = $("#add_forum_topic_title").val();
        var topic_short_description = $("#add_forum_topic_text").val();
            
        if(category_id == ''){
            alert('Please select forum category.');
            $('#select_forum :selected').focus();
            return false;
        }else if(topic_title == ''){
            alert('Please enter topic title.');
            $("#add_forum_topic_title").focus();
            return false;            
        }else if(topic_short_description == ''){
            alert('Please enter short description.');
            $("#add_forum_topic_text").focus();
            return false;            
        }
            
        $.ajax({            
            method:'post',
            url:"<?php echo base_url(); ?>forum/add-topic",            
            data:{'category_id':category_id,'topic_title':topic_title,'topic_short_description':topic_short_description,'category_name':category_name},
            
            success:function(response){                
                $("#forum_post").before(response);
                alert('your topic has been posted successfully.');
                location.reload();
            }   
        });
    }           
    
    /*view more topics*/    
    function view_more_topics(){
    
        var first_count = $('#first_topic_count').val();
        var total_count = $('#total_topic_count').val();
        
        if($('#sort_variable').val() != ''){            
            var sort_variable = $('#sort_variable').val();
        }else{
            var sort_variable = '';
        }       
                
        if($('#posted_key').val() != ''){            
            var posted_key = $('#posted_key').val();
        }else{
            var posted_key = '';
        }       
              
        jQuery.ajax({
            url: '<?php echo base_url(); ?>load-more-topics',
            type:'post',
            dataType:"json",
            data:{'first_count':first_count,'total_count':total_count,'sort_variable':sort_variable,'posted_key':posted_key},
            
            success:function(response){
               
                var posted_key = $("#posted_key").val();
                
                var html_append_forum_topic='';
                var j = 0;
              
                if (response.forum_topics.length > 0) {
                       
                    jQuery.each(response.forum_topics, function(i, forum_topic) {

                        html_append_forum_topic+='<div class="forum_post" id="forum_post">'
                        html_append_forum_topic+='<div class="user_image">';
                                          
                        //forum_topic.profile_picture = (isset(forum_topic.profile_picture)) ? forum_topic.profile_picture : 'photo-45519.png'; 
                        html_append_forum_topic+='<img src="'+javascript_site_path +'media/front/images/profile-images/thumb/'+forum_topic.profile_picture+'"  width="50px" height="50px" title="'+forum_topic.user_name+'">';
                        html_append_forum_topic+='</div>';
                        html_append_forum_topic+='<div class="user_info">';
                        html_append_forum_topic+='<div class="post_u_name">'+forum_topic.user_name+'</div>';
                        /*today = new Date(forum_topic.posted_on);
//                        today = Math.round(new Date(forum_topic.posted_on).getTime()/1000);
                        
                        var dateString = '';
                        var dateString = today.format("dd'<sup>th</sup>' mmm yyyy hh:MM TT");*/
                        //alert(dateString);
                        html_append_forum_topic+='<div class="post_time">'+forum_topic.posted_on_new+'</div>';
                        html_append_forum_topic+='<span> in</span>';
                        html_append_forum_topic+='<div class="post_discussion">'+forum_topic.category_name+'</div>';                        
                        html_append_forum_topic+='<div class="post_social_links">';
                        html_append_forum_topic+='<ul>';
                        html_append_forum_topic+='<li><span class="comment" title="total'+forum_topic.comments.length+'comments">&nbsp;</span>';
                        html_append_forum_topic+='<span class="count" id="comments_'+forum_topic.topic_id+'">'+forum_topic.comments.length+'</span></li>';
                        html_append_forum_topic+='</ul>';
                        html_append_forum_topic+='</div>';  
                        html_append_forum_topic+='</div>';
                        html_append_forum_topic+='<div class="forum_title" onclick="showTopicDescription('+forum_topic.topic_id+')" id="topic_title">';
                        html_append_forum_topic+='<h3>'+highlightkeyword(forum_topic.topic_title,posted_key) +'</h3>';
                        html_append_forum_topic+='</div>';
                        if(response.search_comment_flag == 'yes'){
                            html_append_forum_topic+='<div class="user_comments" style="block: none;" id="user_comment_id_'+forum_topic.topic_id+'">'; 
                        }else{
                            html_append_forum_topic+='<div class="user_comments" style="display: none;" id="user_comment_id_'+forum_topic.topic_id+'">'; 
                        }                          
                        html_append_forum_topic+='<div class="user_comment_data">';
                        html_append_forum_topic+='<p>'+highlightkeyword(forum_topic.topic_content,posted_key)+'</p>';
                        html_append_forum_topic+=' </div>';
                        html_append_forum_topic+='<div class="total_comment" style="display: block;" id="total_comment_'+forum_topic.topic_id+'"><div id="total_comment_count_'+forum_topic.topic_id+'" >Total '+forum_topic.comments.length+' Comments</div></div>';
                                            
                        //if ($forum_topic['comments'] != '') {
                        if (forum_topic.comments.length > 0) {
                               
                            if (forum_topic.comments.length > 0) {
                                
                                html_append_forum_topic+='<div id="forun_uniqe_cmt_'+forum_topic.topic_id +'">';
                                                        
                                jQuery.each(forum_topic.comments,function(ind,comments){
                                                         
                                    html_append_forum_topic+='<div class="user_post_comment" id="user_post_comments_'+comments.comment_id+'" >';                                                           
                                    html_append_forum_topic+='<div class="user_image"><img src="'+javascript_site_path+'media/front/images/profile-images/thumb/'+((comments.c_profile_picture==null)?"photo-45519.png":comments.c_profile_picture)+' "  width="50px" height="50px" title="'+comments.user_name+'"></div>';
                                    html_append_forum_topic+='<div class="user_info">';
                                    html_append_forum_topic+='<div class="post_u_name">'+((comments.user_name==null)?"":comments.user_name)+'</div>';
                                    today = new Date(comments.comment_on);
                                    //var dateString = today.format("dd'<sup>th</sup>' mmm yyyy hh:MM TT");
                                    var dateString = '';
                                    html_append_forum_topic+='<div class="post_time">'+dateString+'</div>';                                                
                                    html_append_forum_topic+='<div class="post_social_links">';
                                    html_append_forum_topic+='</div>';
                                    html_append_forum_topic+='</div>';
                                    html_append_forum_topic+='<div class="user_comment_data">';
                                    html_append_forum_topic+='<p>'+highlightkeyword(comments.comment,posted_key)+'</p>';
                                    //                                    html_append_forum_topic+=; 
                                    html_append_forum_topic+='</p>';
                                    html_append_forum_topic+='</div>';
                                    html_append_forum_topic+='</div>';
                                });/* for */
                                html_append_forum_topic+='</div>';     
                            } else {                               
                                html_append_forum_topic+='<div id="forun_uniqe_cmt_'+forum_topic.topic_id+'"></div>';                                
                            }
                        }else{
                            /* this div is used when there is no comment on topic*/
                            html_append_forum_topic+='<div id="forun_uniqe_cmt_'+forum_topic.topic_id+'"></div>';                        
                        }
                                        
                        if (response.user_session != '') {                         
                            html_append_forum_topic+='<form name="post_comment" id="post_comment" method="" action="">';
                            html_append_forum_topic+='<div class="forums_posted" id="comment_'+forum_topic.topic_id+'" style="display: block;">';
                            html_append_forum_topic+='<input type="text" id="msg_comment_'+forum_topic.topic_id+'" required  name="msg_comment" value="" placeholder="Reply...">';
                            html_append_forum_topic+='<input type="hidden" name="topic_id" id="topic_id" value="'+forum_topic.topic_id+'" />';                                                   
                            html_append_forum_topic+='<input type="button" name="hit_comment"  id="hit_comment" value="Hit comment" title="Hit comment" class="btn_post" onclick="addComment('+forum_topic.topic_id+') ">';
                            html_append_forum_topic+='</div>';
                            html_append_forum_topic+='</form>';
                        }
                        html_append_forum_topic+='</div>';
                        html_append_forum_topic+='</div>';                                                                                                   
                        j++;
                    }); 
                }
                
                jQuery(".forum_list").append(html_append_forum_topic);
                total_count=parseInt($('#view_more').val())-3;
                if(total_count <= 0){
                    $('#view_more').css('display','none'); 
                    $('#view_more_div').css('display','none');                     
                }
                $('#view_more').val(total_count);
                $('#total_topic_count').val(total_count);
                first_count=parseInt(first_count)+3;
                $('#first_topic_count').val(first_count);
            }                   
        });//end ajax                
    }/*function*/    
</script>
