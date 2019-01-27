function show_search(){
   var width = $('#search_nav').width();
   $('#search_layer').width(width);
}
var url_post;
$('#q-search').on('input',function(e){
    if(this.value.length >= 3 || e.keyCode == 13) {
        $('#search_layer').html('');
        if(typeof xhr != 'undefined'){
            xhr.abort();
        }

        xhr = $.ajax({
            type: 'GET',
            url: url,
            data:{'title':this.value},
            success: function (data) {
                show_search();
                url_post = post.slice(0, -2);
                if(data){
                    var html ='';
                    var line;
                    $.each(data,function(key,values){
                         line = "<div class='col-xs-12'><a href='"+url_post+"/"+values['id']+"'>"+values['title']+"</a></div>";
                         html +=line;
                    });
                    $('#search_layer').html(html).show();
                }else{
                    $('#search_layer').html("<span class='col-xs-12'>Not found</span>");
                }
            }
        })
    }
});
$('.icon_delete').on('click',function(e){
    var class_selected = $(this).attr('attr-class');
    var id_selected = $(this).attr('attr-id');
    console.log(class_selected);
    console.log(id_selected);
    if(typeof xhr != 'undefined'){
        xhr.abort();
    }
    var url_admin = url_post = post.slice(0, -6)+"delete_row";
    if(class_selected && id_selected){

        xhr = $.ajax({
        type: 'GET',
        url: url_admin,
        data:{'class_selected':class_selected,'id':id_selected},
        success: function (data) {
            if(data.status && data.status === 200){
               location.reload();
            }else{
                alert(class_selected+ " could not be deleted");
            }
        }
    })
    }
});