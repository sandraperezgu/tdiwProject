@extends('layouts.app')

@section('content')
    @if (Auth::check())
    <post-detail :user="{{ Auth::user()->id }}" :datapost="{{ $post->toJson() }}" :datacomments="{{ $comments->toJson() }}"></post-detail>
    @else
        <post-detail :user="0" :datapost="{{ $post->toJson() }}" :datacomments="{{ $comments->toJson() }}"></post-detail>

    @endif
    <div class="panel-body">
        <form id="form_test" class="form-horizontal" method="POST" action="{{ route('new_answer') }}" style="display:none;">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                <label for="description" class="col-md-4 control-label">Answer</label>
                <div class="col-md-6">
                    <textarea class="form-control" rows="5" name="description" id="description"></textarea>
                    <input type="hidden" name="post_id" value="{{$post->id}}" />
                    @if ($errors->has('description'))
                        <span class="help-block">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        Send
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection