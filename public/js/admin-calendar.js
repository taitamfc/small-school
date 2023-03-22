function admin_delete_calendar(ajax_url,data,method = 'POST'){
    $.ajax({
        url : ajax_url,
        type: method,
        data:data,
        success:function(response){
            
        }
    });
}