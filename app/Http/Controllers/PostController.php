<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    /**
     * Show posts
     *
     * @return \Illuminate\Http\Response
     */
    public function getData()
    {
        $posts =  Post::where('post_id', '=', NULL)->latest()->paginate(15);
        return JsonResponse::fromJsonString($posts);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::with('')->findOrFail($id);
        $comments = Post::where("post_id", "=", $id)->get();
        $data = array('post'=>$post,'comments'=>$comments);
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function setAnswer(Request $request){
        if($request->answer && $request->post){
            $post = Post::where('id', $request->post)->firstOrFail();
            $answer = Post::where('id', $request->answer)->firstOrFail();
            $post->status = POST::CLOSED_POST;
            $answer->status = POST::SELECTED_ANSWER;
            $response = array(
                'status' => 'success',
                'msg' => $request->message,
            );
            $post->save();
            $answer->save();
        }else{
            $response = array(
                'status' => 'error',
            );
        }

        return response()->json($response);
    }
    public function newAnswer(){
        if(isset($_POST['description']) && Auth::check()){
            $id =$_POST['post_id'];
            $post = new Post;
            $post->title = htmlentities($_POST['description']);
            $post->description = htmlentities($_POST['description']);
            $post->status = Post::OPEN_POST;
            $post->user_id = Auth::user()->id;
            $post->post_id = $id;
            $post->rate_number = 0;
            $post->save();
            return redirect()->route('post', ['id' => $id]);
        }else{
            return redirect('home');
        }

    }
    public function createPost(){
        if(isset($_POST['title']) && Auth::check()){
            $post = new Post;
            $post->title = htmlentities($_POST['title']);
            $post->description = htmlentities($_POST['description']);
            $post->status = Post::OPEN_POST;
            $post->user_id = Auth::user()->id;
            $post->rate_number = 0;
            $post->save();
            return redirect()->route('post', ['id' => $post->id]);
        }else{
            return redirect('home');
        }
    }
}
