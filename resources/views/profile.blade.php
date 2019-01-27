@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>My Posts</h1>
        <hr class="separator"/>
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <!-- POST -->
                @foreach($posts as $post)
                    <div class="post">
                        <div class="wrap-ut pull-left">
                            <!-- AVATAR -->
                            <div class="userinfo pull-left">
                                <div class="avatar">
                                    <img src="{{ asset($user->logo_path) }}" alt="">
                                    <div class="status green"></div>
                                </div>
                            </div>
                            <!-- TITULO DEL POST Y DESCRIPCION -->
                            <div class="posttext pull-left">
                                <h2><a class="link" href="{{route('post', ['id' => $post->id])}}">
                                        @if ($post->status == 0)
                                            (CLOSED) {{$post->title}}
                                        @else
                                            {{$post->title}}
                                        @endif
                                    </a>
                                </h2>
                                <p>{{ $post->description }}</p>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="postinfo pull-left">
                            <div class="comments">
                                <div class="commentbg">
                                    @php $total=0 @endphp
                                    @foreach ($replies as $reply)
                                        @if ($post->id == $reply->post_id)
                                            @php $total = $reply->total @endphp
                                        @endif
                                    @endforeach
                                    {{$total}}
                                    <div class="mark"></div>
                                </div>
                            </div>
                            <div class="ranking"><i class="glyphicon glyphicon-star"></i>
                                {{$post->rate_number}}
                            </div>
                            <div class="created_at"><i class="glyphicon glyphicon-time"></i>
                                {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->created_at)->format('Y-m-d')}}
                                {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->created_at)->format('H:i')}}
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                @endforeach
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="sidebarblock">
                    <h3>Tags</h3>
                    <div class="divline"></div>
                    <div class="blocktxt">
                        <ul class="tags">
                            @foreach($numberOfPosts as $number)
                                    <li>
                                        <a href="#">{{$number->tag_id}}
                                            <span class="badge pull-right">{{$number->total}}</span>
                                        </a>
                                    </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection