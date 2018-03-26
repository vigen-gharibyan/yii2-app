$(function() {
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();

    $('#order-save').click(function(){
        items = $('#sortable li');
        var orderIds = [];
        $.each(items, function(i, item){
            orderId = $(item).attr('data-orderId');
            orderIds[i] = orderId;
        });

        url = baseUrl +'/language/order';
        $.ajax({
            url: url,
            type: 'POST',
        //  contentType: 'application/json',
            dataType: 'json',
            data: {'orderIds':orderIds},
            beforeSend: function(){
                $('#error-message').html('');
            },
            success: function(data){
                if(data.success) {
                    window.location.replace(baseUrl + "/language/index");
                } else {
                    $('#error-message').html(error_message);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
            //  alert("Status: " + textStatus);
            //  alert("Error: " + errorThrown);
                $('#error-message').html(error_message);
            }
        });
    });
});