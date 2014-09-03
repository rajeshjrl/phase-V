/**
 *
 * Crop Image While Uploading With jQuery
 * 
 * Copyright 2014, Resalat Haque
 * http://www.panaceatek.com/
 *
 */

// set info for cropping image using hidden fields
function setInfo(i, e) {
    $('#x').val(e.x1);
    $('#y').val(e.y1);
    $('#w').val(e.width);
    $('#h').val(e.height);
}

$(document).ready(function() {
    var p = $("#uploadPreview");        
    // prepare instant preview
    $("#upload_profile_picture").change(function(){
        // fadeOut or hide preview
        p.fadeOut();

        // prepare HTML5 FileReader
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("upload_profile_picture").files[0]);

        oFReader.onload = function (oFREvent) {
            p.attr('src', oFREvent.target.result).fadeIn();
        };
    });

    // implement imgAreaSelect plug in (http://odyniec.net/projects/imgareaselect/)
    $('img#uploadPreview').imgAreaSelect({
        // set crop ratio (optional)
        aspectRatio: '1:1',
        onSelectEnd: setInfo
    });
});
