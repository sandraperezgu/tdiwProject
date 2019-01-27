<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = DB::table('tag')->get();
        $numberOfPosts = DB::table('post_tag')
            ->select('tag_id', DB::raw('count(*) as total'))
            ->groupBy('tag_id')
            ->get();

        return view('welcome', ['tags'=> $tags, 'numberOfPosts'=> $numberOfPosts]);
    }

    /**
     * Show posts
     *
     * @return \Illuminate\Http\Response
     */
    public function getData()
    {
        $num_posts = 15;
        $pages = $_GET['page'];
        $page_multiplier = $pages - 1;
        $skip = $page_multiplier*$num_posts;
        $posts =  Post::where('post.post_id', '=', NULL);
        if(isset($_GET['title']) && $_GET['title']){
            $posts = $posts->where('post.title', 'LIKE', '%'.$_GET['title'].'%');
        }
        if(isset($_GET['tags']) && $_GET['tags']){
            $tags = explode(",",$_GET['tags']);
            $posts = $posts->join('post_tag', 'post.id', '=', 'post_tag.post_id');
            //$posts->groupBy('post_tag.post_id')->having('aggregate', '>=', count($tags));
            $posts = $posts->whereIn('post_tag.tag_id', $tags);
        }
        $posts = $posts->skip($skip)->paginate($num_posts);
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

        $tags = DB::table('tag')->get();
        $post = Post::where('id', $id)->firstOrFail();
        $comments = Post::where("post_id", "=", $id)->get();
        $numberOfPosts = DB::table('post_tag')
            ->select('tag_id', DB::raw('count(*) as total'))
            ->groupBy('tag_id')
            ->get();
        return view('post', ['post' => $post,'comments'=>$comments, 'tags'=>$tags, 'numberOfPosts'=> $numberOfPosts]);
    }
    public function votePost(Request $request){
        if($request->has('post_id') && Auth::check()){
            $user_id = Auth::user()->id;
            $post_id = $request->get('post_id');

            $vote = $request->get('vote');
            $post = Post::where('id', $post_id)->firstOrFail();
            $already_voted = DB::table('post_user')->where("post_id", "=", $post_id)->where("user_id", "=", $user_id)->get();
            if($post && !$already_voted->first()){
                $post->votes()->attach(Auth::user());
                if($vote == 1) $post->rate_number = $post->rate_number+1;
                else $post->rate_number = $post->rate_number-1;
                $post->save();
            }
            return response()->json(true);
        }
        return response()->json(false);
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
    /* Recieves title by GET, get 3 first ones and return them as array.*/
    public function searchPost(){
        $title = $_GET['title'];
        $limit = (isset($_GET['limit']) && $_GET['limit']) ? $_GET['limit'] : 3;
        $posts =  Post::whereNull('post_id')->where('title', 'LIKE', '%'.$title.'%')->limit($limit)->get();
        return JsonResponse::fromJsonString($posts);
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

            if(isset($_POST['tag'])){

                $tags = explode(',', $_POST['tag']);

                foreach($tags as $tag){
                    // Falta controlar que no se inserten los que ya están en BBDD
                    $newTag = Tag::where("name", "=", $tag)->first();

                    if (!$newTag){
                        $newTag = new Tag;
                        $newTag->name = $tag;
                        $newTag->save();
                    }

                }

                $post->tags()->attach($tags);
            }

            $post->save();

            return redirect()->route('post', ['id' => $post->id]);
        }else{
            return redirect('home');
        }
    }
}
