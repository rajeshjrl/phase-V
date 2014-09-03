function isPasswordStrong(value, element) {
    var pass_result = checkStrength(value, element);
    if (pass_result == 'Strong') {
        return true;
    } else {
        return false;
    }
}
function checkStrength(password) {

    //initial strength
    var strength = 0   

    //if password contains both lower and uppercase characters, increase strength value
    if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/))
        strength += 1

    //if it has numbers and characters, increase strength value
    if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/))
        strength += 1

    //if it has one special character, increase strength value
    if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/))
        strength += 1

    //if it has two special characters, increase strength value
    //if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/))
    //  strength += 1
    
    //if the password length is less than 8, return message.
    if (password.length < 8) {
        $('#result').removeClass();
        // display process bar instead of error message
        $(".password-meter-bar").removeClass().addClass("password-meter-bar").addClass("password-meter-very-weak");
        $(".password-meter-message")
        .removeClass()
        .addClass("password-meter-message")
        .addClass("password-meter-message-very-weak")
        .text('Very weak');
        return jQuery.format("Very weak")
    }

    //length is ok, lets continue.

    //if length is 8 characters or more, increase strength value
    if (password.length > 8)
        strength += 1

    //now we have calculated strength value, we can return messages
    //if value is less than 2
    if (strength == 1) {
        $('#result').removeClass();
        // display process bar instead of error message
        $(".password-meter-bar").removeClass().addClass("password-meter-bar").addClass("password-meter-to-short");
        $(".password-meter-message")
        .removeClass()
        .addClass("password-meter-message")
        .addClass("password-meter-message-to-short")
        .text('Too short');
        return 'Too short'
    } else if (strength == 2) {
        $('#result').removeClass();
        // display process bar instead of error message
        $(".password-meter-bar").removeClass().addClass("password-meter-bar").addClass("password-meter-weak");
        $(".password-meter-message")
        .removeClass()
        .addClass("password-meter-message")
        .addClass("password-meter-message-weak")
        .text('Weak');
        return 'Weak'
    } /*else if (strength == 3) {
        $('#result').removeClass();
        // display process bar instead of error message
        $(".password-meter-bar").removeClass().addClass("password-meter-bar").addClass("password-meter-good");
        $(".password-meter-message")
                .removeClass()
                .addClass("password-meter-message")
                .addClass("password-meter-message-good")
                .text('Good');
        return 'Good'
    }*/ else {
        $('#result').removeClass();
        // display process bar instead of error message
        $(".password-meter-bar").removeClass().addClass("password-meter-bar").addClass("password-meter-strong");        
        $(".password-meter-message")
        .removeClass()
        .addClass("password-meter-message")
        .addClass("password-meter-message-strong")
        .text('strong');
        return 'Strong'
    }
}