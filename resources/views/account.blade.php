@extends('layouts.app')

@section('content')
    <div class="container">
        <!--<h1>My Account</h1>
        <hr class="separator"/>-->
        <div class="row">
            <div class="col-lg-8 col-md-8">

                <!-- POST -->
                <div class="post">
                    <form action="{{route('modify')}}" class="form" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="postinfotop">
                            <h2>My Account</h2>
                        </div>
                        <!-- acc section -->
                        <div class="accsection">
                            <div class="acccap">
                                <div class="userinfo pull-left">&nbsp;</div>
                                <div class="posttext pull-left"><h3>General account settings</h3></div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="topwrap">
                                <div class="userinfo pull-left">
                                    <div class="avatar">
                                        <img src="{{ asset($user->logo_path) }}" alt="">
                                        <div class="status green">&nbsp;</div>
                                    </div>
                                </div>
                                <div class="posttext pull-left">

                                    <div>
                                        <input type="text" placeholder="{{$user->name}}" name="name"
                                               class="form-control">
                                        <input type="text" placeholder="{{$user->email}}" name="email"
                                               class="form-control">
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <input type="password" placeholder="Password" name="password"
                                                   class="form-control" id="pass"
                                                   name="pass">
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <input type="password" placeholder="Retype Password" class="form-control"
                                                   id="pass2"
                                                   name="pass2">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <p>Change my avatar</p>
                                            <input type="file" id="file" name="file">
                                        </div>
                                    </div>

                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div><!-- acc section END -->


                        <!-- acc section -->
                        <div class="accsection privacy">
                            <div class="acccap">
                                <div class="userinfo pull-left">&nbsp;</div>
                                <div class="posttext pull-left"><h3>Privacy</h3></div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="topwrap">
                                <div class="userinfo pull-left">&nbsp;</div>
                                <div class="posttext pull-left">

                                    <div class="row newtopcheckbox">
                                        <div class="col-lg-6 col-md-6">
                                            <div><p>Who can see my profile?</p></div>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" id="everyone"> Everyone
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" id="me"> Only me
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div><!-- acc section END -->

                        <div class="postinfobot">
                            <div class="pull-right postreply">
                                <div class="pull-left smile"><a href="#"><i class="fa fa-smile-o"></i></a></div>
                                <div class="pull-left">
                                    <button type="submit" class="btn btn-primary">Modify</button>
                                </div>
                                <div class="clearfix"></div>
                            </div>


                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div><!-- POST -->


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