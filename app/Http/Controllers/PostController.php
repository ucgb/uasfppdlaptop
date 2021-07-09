<?php

namespace App\Http\Controllers;

use App\Models\Post;


use Illuminate\Http\Request;

class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  landing page
    public function view()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(4);
        return view('/pages.index', ['posts' => $posts]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        return view('/pages.post.dashboard');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  landing page
    public function index()
    {
        $userId = auth()->user()->id;
        // $posts = Post::where(['user_id' => $userId])->get();
        $posts = Post::where(['user_id' => $userId])
            ->orderBy('id', 'desc')
            ->paginate(4);
        return view('/pages/post.view', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->validate([
            'merk' => 'required',
            'seri' => 'required',
            'tahun' => 'required',
        ]);

        $userId = auth()->user()->id;
        $input = $request->input();
        $input['user_id'] = $userId;
        $postStatus = post::create($input);

        if ($postStatus) {
            $request->session()->flash('success', 'Post successfully added');
        } else {
            $request->session()->flash('error', 'Oops something went wrong, Post not Published');
        }
        return redirect('post');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::where(['user_id' => $userId, 'id' => $id])->first();
        if (!$post) {
            return redirect('post')->with('error', 'Post not found');
        }
        return view('post.detail', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userId = auth()->user()->id;
        $post = Post::where(['user_id' => $userId, 'id' => $id])->first();
        if ($post) {
            return view('pages.post.edit', ['post' => $post]);
        } else {
            return redirect('post')->with('error', 'post not found');
        }
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
        $userId = auth()->user()->id;
        $post = Post::find($id);
        if (!$post) {
            return redirect('post')->with('error', 'Post not found.');
        }
        $input = $request->input();
        $input['user_id'] = $userId;
        $postStatus = $post->update($input);
        if ($postStatus) {
            return redirect('post')->with('success', 'Post successfully updated.');
        } else {
            return redirect('post')->with('error', 'Oops something went wrong. Post not updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userId = auth()->user()->id;
        $post = Post::where(['user_id' => $userId, 'id' => $id])->first();
        $respStatus = $respMsg = '';
        if (!$post) {
            $respStatus = 'error';
            $respMsg = 'Post not found';
        }
        $postDelStatus = $post->delete();
        if ($postDelStatus) {
            $respStatus = 'success';
            $respMsg = 'Post deleted successfully';
        } else {
            $respStatus = 'error';
            $respMsg = 'Oops something went wrong. Post not deleted successfully';
        }
        return redirect('post')->with($respStatus, $respMsg);
    }
}
