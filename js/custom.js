$(function(){
    $('.order__form-button_send').on('click', function (e) {
        e.preventDefault();
        var form = $(this).closest('form'),
            post = $.ajax({
                url: form.attr('action'),
                data: form.serialize() ,
                type: form.attr('method'),
                dataType: 'json'
            });
        $('.order__message').html('');
        post.done(function(data){
            if (data.status) {
                $('.order__message').html("<p style='color:green'>" + data.order + "</p>");
            } else {
                if (data.errors.length) {
                    $.each(data.errors, function( index, value ) {
                        $('.order__message').append("<p style='color:red'>" + value + "</p>");
                    });
                } else {
                    $('.order__message').html("error!");
                }
            }
        });

        post.fail(function(){
            $('.order__message').html("fatal error!");
        });
    });
});