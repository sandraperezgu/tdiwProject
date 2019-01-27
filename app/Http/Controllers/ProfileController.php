<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    const ROLE_ADMIN = 1;
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

        $user = DB::table('users')
            ->select('logo_path')
            ->where('id', '=', $id)
            ->get();

        return view('profile', ['posts' => $posts, 'tags' => $tags, 'replies' => $replies, 'numberOfPosts' => $numberOfPosts, 'user'=>$user[0]]);
    }

    public function account()
    {
        $id = Auth::user()->id;

        $user = DB::table('users')
            ->select('id', 'name', 'email', 'logo_path', 'created_at')
            ->where('id', '=', $id)
            ->get();

        $numberOfPosts = DB::table('post_tag')
            ->select('tag_id', DB::raw('count(*) as total'))
            ->groupBy('tag_id')
            ->get();

        return view('account', ['user' => $user[0], 'numberOfPosts' => $numberOfPosts]);
    }

    public function modifyAccount(Request $request)
    {

        $id = Auth::user()->id;

        if ($request->has('name')) {
            DB::table('users')
                ->where('id', $id)
                ->update(['name' => $request->name]);
        }
        if ($request->has('email')) {
            DB::table('users')
                ->where('id', $id)
                ->update(['email' => $request->email]);
        }
        if ($request->has('password')) {
            DB::table('users')
                ->where('id', $id)
                ->update(['password' => $request->password]);
        }


        if ($request->hasFile('file')) {

            $file = $request->file('file');
            //Move Uploaded File
            $destinationPath = 'images/users';
            $file->move($destinationPath, $file->getClientOriginalName());
            $destinationPathPlusName = $destinationPath . '/' . $file->getClientOriginalName();

            // Uploading bbdd
            DB::table('users')
                ->where('id', $id)
                ->update(['logo_path' => $destinationPathPlusName]);
        }

        return redirect('/account');
    }
    public function admin()
    {
        if(!Auth::user() || Auth::user()->role_id != ProfileController::ROLE_ADMIN) return view('welcome');
        $posts = DB::table('post')->whereNull('post_id')->get();

        $tags = DB::table('tag')->get();

        $numberOfPosts = DB::table('post_tag')
            ->select('tag_id', DB::raw('count(*) as total'))
            ->groupBy('tag_id')
            ->get();


        return view('admin', ['posts' => $posts, 'tags' => $tags,'numberOfPosts'=> $numberOfPosts]);
    }
    public function deleteRow(Request $request){
        $class = $request->get('class_selected');
        $id = $request->get('id');
        $code = 200;
        if($class == 'post'){
            try {
                Post::where('post_id', $id)->delete();
                DB::table('post_tag')->where('post_id', $id)->delete();
                DB::table('post')->whereNull('post_id')->where([
                    ['id', '=', $id]
                ])->delete();
            }catch(\Exception $exception){
                $code = $exception;
            }
            $request->session()->flash('alert-success', 'Post is deleted successfully.');
        }else if($class == 'tag'){

        }else{
            $code = 502;
        }
        return response()->json([
            'status' => $code,
        ]);
    }
}
