// JavaScript Document
var inputP;

jQuery(document).ready(function(e) {
		
    jQuery("#frmComments").validate(
    {
        errorElement:"div",
        errorClass:"text-danger",
        debug: true,
        invalidHandler:function(){
            jQuery("#preloader").hide();
        },
        rules:
        {
            inputComment:
            {
                required:true,
                minlength:25
            }
        },
        messages:
        {
            inputComment:
            {
                required:"Please enter your comment",
                minlength:"Please enter {0} characters"
            }
        },
        submitHandler: function(form) {
            var arrCommentData=new Object();
            arrCommentData.msg_comment=jQuery("#inputComment").val();
            arrCommentData.p=inputP;
            saveCommentInfo(arrCommentData);
        }	
    });
		
    jQuery("#btnPostComment").bind("click",function(){
															
															
        jQuery('#frmComments').submit();
															
    });
});
	
function saveCommentInfo(objParams)
{
    jQuery.post(SITE_PATH+"blog/add-comment",objParams,handleCommentPosted,'json');
}
	
function handleCommentPosted(msg)
{
		
    if(msg.error=="1")
    {
        alert("Error while processing your request.\n\nPlease try again!");
    }
    else
    {
        alert("Your comment is successfully placed.");
        location.href=location.href;
    }
}
	
function setInputP(strInputP)
{
    inputP	= strInputP;
}