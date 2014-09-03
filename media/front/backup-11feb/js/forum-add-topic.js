// JavaScript Document
var inputP;

jQuery(document).ready(function(e) {
		
    jQuery("#frmForumTopic").validate(
    {
        errorElement:"div",
        errorClass:"text-danger",
        debug: true,
        invalidHandler:function(){
            jQuery("#preloader").hide();
        },
        rules:
        {
            inputForumTitle:
            {
                required:true,
                minlength:5
            },
            inputForumTopicShortDescription:
            {
                required:true,
                minlength:25
            }
        },
        messages:
        {
            inputForumTitle:
            {
                required:"Please enter topic title",
                minlength:"Please enter {0} characters"
            },
            inputForumTopicShortDescription:
            {
                required:"Please enter short description",
                minlength:"Please enter {0} characters"
            }
        },
        submitHandler: function(form) {
            var arrCommentData=new Object();
            arrCommentData.topic_title=jQuery("#inputForumTitle").val();
            arrCommentData.topic_short_description=jQuery("#inputForumTopicShortDescription").val();
            arrCommentData.topic_description=jQuery("#inputForumTopicDescription").val();
            arrCommentData.topic_meta_keywords=jQuery("#inputForumTopicMetaKeywords").val();
            arrCommentData.topic_meta_description=jQuery("#inputForumTopicMetaDescription").val();
            arrCommentData.topic_category=jQuery("#inputCategory").val();
            arrCommentData.topic_page_title=jQuery("#inputForumTopicPageTitle").val();
            saveTopicInfo(arrCommentData);
        }	
    });
		
    jQuery("#inputForumTopicDescription").cleditor();
		
    jQuery("#btnAddTopic").bind("click",function(){
															
        jQuery('#frmForumTopic').submit();
															
    });
});
	
function saveTopicInfo(objParams)
{
    jQuery.post(SITE_PATH+"forum/add-forum-topic",objParams,handleTopicPosted,'json');
}
	
function handleTopicPosted(msg)
{
		
    if(msg.error=="1")
    {
        alert("Error while processing your request.\n\nPlease try again!");
    }
    else
    {
        alert("Your topic is successfully placed.\n\nYour request is in stage of approval");
        location.href=location.href;
    }
}
	