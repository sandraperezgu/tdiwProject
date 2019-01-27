@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Admin</h1>
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
                                    <img src="images/avatar.jpg" alt="">
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
                                    <i class="glyphicon glyphicon-remove icon_delete" attr-class="post" attr-id="{{$post->id}}"></i>
                                </h2>
                                <p>{{ $post->description }}</p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
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