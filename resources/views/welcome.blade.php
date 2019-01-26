@extends('layouts.app')

@section('content')
    <posts :datanumbersofposts="{{ $numberOfPosts->toJson() }}"></posts>
@endsection