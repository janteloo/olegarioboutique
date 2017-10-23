$(function() {
    $('.img-container').addClass('loading');
    var imageContainers = $('.img-container');
    $.ajax({
        url: "././php/FacebookLoader.php",
        type: "GET",
        cache: false,
        success: function(data) {
            var obj = $.parseJSON(data);
            $.each(obj, function(index, element) {
                var currentImage = imageContainers[index];
                if(element.description != null) {
                  $(currentImage).append('<p>' + element.description + '</p>');
                }
                $(currentImage).css("background-image", "url('"+ element.url +"')");
                $(currentImage).parent().attr("href", element.url);
                $(currentImage).removeClass('loading');
                $(currentImage).parent().removeClass('disabled');
                $(currentImage).append("<div class='overlay'></div>");
                enableClickEvent($(currentImage).parent());
            });
        },
        error: function(error) {
            $(imageContainers).each(function() {
                $(this).parent().removeClass('loading');
                $(this).append("<p> Huo un error al intentar cargar la imágen de Facebook.");
            });
        }
    });

    $('.disabled').click(function(event) {
        return true;
    })
});

function enableClickEvent(element) {
    $(element).click(function(event) {
        return true;
    });
}