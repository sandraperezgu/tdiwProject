@extends('layouts.app')

@section('content')
    <posts :datanumbersofposts="{{ $numberOfPosts->toJson() }}" :datareplies="{{ json_encode($replies) }}" :datausers="{{ json_encode($users) }}"></posts>
@endsection