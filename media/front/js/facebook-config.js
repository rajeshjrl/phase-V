//Facebook connect for user registration start 
window.fbAsyncInit = function() {
    FB.init({
        appId: '177001442424158',
        channelUrl: "//WWW.YOUR_DOMAIN.COM/channel.html", // Channel File
        status: true, // check login status
        cookie: true, // enable cookies to allow the server to access the session
        picture: "http://www.fbrell.com/f8.jpg",
        xfbml: true  // parse XFBML
    });
};
// Load the SDK Asynchronously
(function(d) {
    var js, id = "facebook-jssdk", ref = d.getElementsByTagName("script")[0];
    if (d.getElementById(id)) {
        return;
    }
    js = d.createElement("script");
    js.id = id;
    js.async = true;
    js.src = "//connect.facebook.net/en_US/all.js";
    ref.parentNode.insertBefore(js, ref);
}(document));