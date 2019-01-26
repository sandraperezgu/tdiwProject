<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('profile');
    }

    public function profile()
    {

        $id = Auth::user()->id;

        $posts = DB::table('post')->whereNull('post_id')->where([
            ['user_id', '=', $id]
        ])->get();


        $replies = DB::table('post')
            ->select('post_id', DB::raw('count(*) as total'))
            ->groupBy('post_id')
            ->having('post_id', '>', 0)
            ->get();

        $tags = DB::table('tag')->get();

        $numberOfPosts = DB::table('post_tag')
                        ->select('tag_id', DB::raw('count(*) as total'))
                        ->groupBy('tag_id')
                        ->get();


        return view('profile', ['posts' => $posts, 'tags' => $tags, 'replies'=> $replies, 'numberOfPosts'=> $numberOfPosts]);
    }

}
