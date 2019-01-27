@extends('layouts.app')

@section('content')
    @if (Auth::check())
        <post-detail :user="{{ Auth::user()->id }}" :datapost="{{ $post->toJson() }}"
                     :datacomments="{{ $comments->toJson() }}" :datanumbersofposts="{{ $numberOfPosts->toJson() }}" :datausers="{{ json_encode($users) }}"></post-detail>
    @else
        <post-detail :user="0" :datapost="{{ $post->toJson() }}" :datacomments="{{ $comments->toJson() }}"
                     :datanumbersofposts="{{ $numberOfPosts->toJson() }}" :datausers="{{ json_encode($users) }}"></post-detail>

    @endif
    <div class="post" id="form_test" style="display:none;">
        <form class="form" method="post" action="{{ route('new_answer') }}">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                <div class="topwrap">
                    <div class="userinfo pull-left">
                        <div class="avatar">
                            <img src="images/avatar4.jpg" alt="">
                            <div class="status red">&nbsp;</div>
                        </div>
                    </div>
                    <div class="posttext pull-left">
                        <div class="textwraper">
                            <label for="description" class="col-md-4 control-label">Answer</label>
                            <div class="postreply">Post a Reply</div>
                            <textarea class="form-control" name="description" id="description"
                                      placeholder="Type your message here" required></textarea>
                            <input type="hidden" name="post_id" value="{{$post->id}}"/>
                            @if ($errors->has('description'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="postinfobot">
                    <div class="pull-right postreply">
                        <div class="pull-left">
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </form>
    </div>

@endsection