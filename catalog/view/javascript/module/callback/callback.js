$(function(){
    var colorbox_defaults = {maxWidth:'90%', fixed: true, opacity: 0.5, overlayClose: true, xhrError: callback_loc.js_request_error};
    $('.modal-ajax').colorbox(colorbox_defaults);
    var callbackFormSubmit = function(e){
        e.preventDefault();
        var $form = $(this);
        $.colorbox(colorbox_defaults);
        $.ajax({
            url: $form.attr('action'),
            data: $form.serialize(),
            dataType: 'html',
            type: 'POST',
            success: function($data){
                $.colorbox($.extend({html: $data}, colorbox_defaults));
            },
            error: function(jqXHR, textStatus){
                switch(textStatus){
                    case 'error':
                    case 'parsererror':
                    case 'abort':
                        $.colorbox($.extend({html: callback_loc.js_request_error}, colorbox_defaults));
                        break;
                    case 'timeout':
                        $.colorbox($.extend({html: callback_loc.js_request_timeout}, colorbox_defaults));
                        break;
                }
            }
        });
    };
    $(document).on('cbox_complete',function(){
        $('.callback-form').on('submit', callbackFormSubmit);
    });
});
