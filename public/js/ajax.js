function ajax_call(action_url, element_response_id, args){
    $('#obscure-loading').fadeIn("slow");
    
    $.ajax({
        type:  'POST',
        async: true,
        url:   action_url,
        cache: true,
        dataType: 'json',
        data:  args,
        success: function(data){
            if ( data.success ){
                $('#' + element_response_id).html(data.result);
            }
            
            $('#obscure-loading').fadeOut("slow");
        },
        error: function(jqXHR, textStatus, errorThrown){
            $('#obscure-loading').fadeOut("slow");
            
            var error = $.parseJSON(jqXHR.responseText);
            var content = error.content;
            console.log(content.message);
            if(content.display_exceptions)
                console.log(content.exception.xdebug_message);
        }
    });
}