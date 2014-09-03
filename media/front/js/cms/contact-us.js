$(document).ready(function(e){      
    /*validation for contact form*/
    $('#contact_us_frm').validate({
        errorElement: "div",
        rules:{
            reply_email:{
                required:true,
                email:true
            },
            message:{
                required:true
            },
            attachment:{
                accept :'png|jpeg|jpg|gif'
            }
        },
        messages:{
            reply_email:{
                required:"please enter your email address.",
                email:"Please enter valid email address."
            },
            message:{
                required:'Please enter your query here.'
            },
            attachment:{
                accept :'please upload png,jpeg,jpg,gif format images only.'
            }                
        }            
    })
});
