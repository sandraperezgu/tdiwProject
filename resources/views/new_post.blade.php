@extends('layouts.app')

@section('content')
   <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>-->
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create new Post</div>

                <div class="panel-body">
                    <form class="form-horizontal" id="formCreatePost" method="POST" action="{{ route('new_post') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">Title</label>

                            <div class="col-md-6">
                                <textarea class="form-control" rows="2" name="title" id="title"></textarea>
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-4 control-label">Description</label>

                            <div class="col-md-6">
                                <textarea class="form-control" rows="5" name="description" id="description"></textarea>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Tags</label>
                            <div class="col-md-6">
                                <input type="text" name="tag" id="tag" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" id="submit" class="btn btn-primary">
                                    Create
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){

        $('#tag').tokenfield({
            autocomplete:{
                source: ['PHP','Codeigniter','HTML','JQuery','Javascript','CSS','Laravel','CakePHP','Symfony','Yii 2','Phalcon','Zend','Slim','FuelPHP','PHPixie','Mysql'],
                delay:100
            },
            showAutocompleteOnFocus: true
        });

        $('#formCreatePost').on('submit', function(event){
            event.preventDefault();
            if($.trim($('#title').val()).length == 0)
            {
                alert("Please enter Title");
                return false;
            }
            else if($.trim($('#description').val()).length == 0)
            {
                alert("Please enter Tag(s)");
                return false;
            }
            else
            {
                var form_data = $(this).serialize();
                $('#submit').attr("disabled","disabled");
                $.ajax({
                    url:"insert.php",
                    method:"POST",
                    data:form_data,
                    beforeSend:function(){
                        $('#submit').val('Submitting...');
                    },
                    success:function(data){
                        if(data != '')
                        {
                            $('#name').val('');
                            $('#tag').tokenfield('setTokens',[]);
                            $('#success_message').html(data);
                            $('#submit').attr("disabled", false);
                            $('#submit').val('Submit');
                        }
                    }
                });
                setInterval(function(){
                    $('#success_message').html('');
                }, 5000);
            }
        });

    });
</script>

@endsection
