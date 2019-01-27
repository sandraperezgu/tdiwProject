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
        if(Auth::check()){
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

            return view('profile', ['posts' => $posts, 'tags' => $tags, 'replies' => $replies, 'numberOfPosts' => $numberOfPosts, 'user' => $user[0]]);
        }

        return redirect('/');

    }

    public function account()
    {
        if (Auth::check()) {
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

        return redirect('/');

    }

    public function modifyAccount(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($request->has('name')) {
               $user->name=$request->name;
            }
            if ($request->has('email')) {
               $user->email = $request->email;
            }
            if ($request->has('password') && $request->has('pass2')) {
                if($request->password == $request->pass2){
                    $user->password = bcrypt($request->password);
                }
            }


            if ($request->hasFile('file')) {

                $file = $request->file('file');
                //Move Uploaded File
                $destinationPath = 'images/users';
                $file->move($destinationPath, $file->getClientOriginalName());
                $destinationPathPlusName = $destinationPath . '/' . $file->getClientOriginalName();

                // Uploading bbdd
               $user->logo_path = $destinationPathPlusName;
            }
            $user->save();
            return redirect('/account');
        }
        return redirect('/');

    }

    public function admin()
    {
        if (!Auth::check() || Auth::user()->role_id != ProfileController::ROLE_ADMIN) return redirect('/');

        $id = Auth::user()->id;

        $posts = DB::table('post')->whereNull('post_id')->get();

        $tags = DB::table('tag')->get();

        $numberOfPosts = DB::table('post_tag')
            ->select('tag_id', DB::raw('count(*) as total'))
            ->groupBy('tag_id')
            ->get();

        $user = DB::table('users')
            ->select('logo_path')
            ->where('id', '=', $id)
            ->get();


        return view('admin', ['posts' => $posts, 'tags' => $tags, 'numberOfPosts' => $numberOfPosts, 'user'=>$user[0]]);
    }

    public function deleteRow(Request $request)
    {
        $class = $request->get('class_selected');
        $id = $request->get('id');
        $code = 200;
        if ($class == 'post') {
            try {
                Post::where('post_id', $id)->delete();
                DB::table('post_tag')->where('post_id', $id)->delete();
                DB::table('post_user')->where('post_id', $id)->delete();
                DB::table('post')->whereNull('post_id')->where([
                    ['id', '=', $id]
                ])->delete();
            }catch(\Exception $exception){
                $code = 500;
            }
            $request->session()->flash('alert-success', 'Post is deleted successfully.');
        }else if($class == 'tags'){
            try{
            DB::table('post_tag')->where('tag_id', $id)->delete();
            DB::table('tag')->where([
                ['name', '=', $id]
            ])->delete();
        }catch(\Exception $exception){
            $code = 500;
        }
            $request->session()->flash('alert-success', 'Tag is deleted successfully.');
        }else{
            $code = 500;
        }
        return response()->json([
            'status' => $code,
        ]);
    }

    public function deleteAccount()
    {
        if (Auth::check()) {
            $id = Auth::user()->id;
            $hasPosts = DB::table('post')->where('user_id', $id)->get();

            if($hasPosts->first()){
                return redirect('account');
            }else{
                DB::table('users')->where('id', $id)->delete();
            }

        }
        return redirect('/');

    }
}
