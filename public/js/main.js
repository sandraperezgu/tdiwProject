function show_search(){
   var width = $('#search_nav').width();
   $('#search_layer').width(width);
}
var url_post
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