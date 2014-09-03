// JavaScript Document

jQuery(function(){    
    // add multiple select / deselect functionality
    
    jQuery("#check_all").change(function () {
       
        if (jQuery('#check_all').attr('checked')) {
            jQuery('.case').each(function(){
                $(this).attr("checked",true);
                $(this).parent('span').addClass('checked');
            });
        }
        else
        {
            jQuery('.case').each(function(){
                $(this).attr("checked",false);
                $(this).parent('span').removeClass('checked');
            });
        }
    });
	
    jQuery(".case").change(function () {
        var a=1;
        jQuery('.case').each(function(){
            if (!this.checked) {
                a=0;  // if one of the is listed chekcbox is not  cheacked
                jQuery('input[name=check_all]').attr('checked', false);
                jQuery('input[name=check_all]').parent().removeClass('checked');
            }
        });
        if(a==1)
        {
            jQuery('input[name=check_all]').attr('checked', true);
            jQuery('input[name=check_all]').parent().addClass('checked');
        }
    });
	
/*$(".row-fluid select").change(function(){	
			jQuery("#check_all").attr("checked",false);
			jQuery("#check_all").parent('span').removeClass('checked');
			jQuery('.case').each(function(){
                $(this).attr("checked",false);
                $(this).parent('span').removeClass('checked');
            });
	});
	*/
	
/*jQuery(".row-fluid ul").click(function(){
						alert($(this).element().clikced
			
			/*jQuery("#check_all").attr("checked",false);
			
			jQuery("#check_all").parent('span').removeClass('checked');
			jQuery('.case').each(function(){
                $(this).attr("checked",false);
                $(this).parent('span').removeClass('checked');
            });
			
	});*/
	
});

function deleteConfirm()
{
    var del_num=0;
	
    /* jQuery('.checked').each(function(){
        del_num=1; 
    });
	*/
	
    jQuery('.case').each(function(){
        if (this.checked) {
            del_num=1;
        }
    });
	
    if(!del_num){
        alert("Please select atleast one record to delete");
        return false;
    }
    else{
        var status=confirm("Do you really want to delete?");
        if(status)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}