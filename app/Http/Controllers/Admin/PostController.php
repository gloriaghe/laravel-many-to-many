<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
// use App\Models\User;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    protected $perPage = 20;
    public function index()
    {

        $posts = Post::paginate($this->perPage);

        return view('admin.posts.index', compact('posts'));
    }
    public function myIndex()
    {

        $posts = Auth::user()->posts()->paginate($this->perPage);

        return view('admin.posts.index', compact('posts'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.create', [
            'categories'    => $categories,
            'tags'          => $tags,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required|string|max:100',
            'slug'      => 'required|string|max:100|unique:posts',
            'category_id'  => 'required|integer|exists:categories,id',
            'tags'      => 'nullable|array',
            'tags.*'    => 'integer|exists:tags,id',
            'image'     => 'required_without:content|nullable|url',
            'content'   => 'required_without:image|nullable|string|max:5000',
            'excerpt'   => 'nullable|string|max:200',
        ]);
//con il + aggiungiamo all'array l'Id dell'utente
        $data = $request->all() + [
            'user_id' => Auth::id(),
        ];

        $post = Post::create($data);
        $post->tags()->sync($data['tags']);

        return redirect()->route('admin.posts.show', ['post' => $post]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {

             $categories = Category::all();
             $tags = Tag::all();
            // $user = User::all();

            // return view('admin.posts.show', compact('post'));

            return view('admin.posts.show', [
             'post'          => $post,
             'categories'    => $categories,
            'tags'          => $tags,
        //     // 'user' => $user
         ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)

    {
        if(Auth::id() != $post->user_id) abort(401);

        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.edit', [
            'post'          => $post,
            'categories'    => $categories,
            'tags'          => $tags,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title'     => 'required|string|max:100',
            'slug'      => [
                'required',
                'string',
                'max:100',
                //ignora il fatto che lo slug deve essere univoco siccome serve per lo stesso post
                Rule::unique('posts')->ignore($post->id),
            ],
            'category_id'  => 'required|integer|exists:categories,id',
            'tags'      => 'nullable|array',
            'tags.*'    => 'integer|exists:tags,id',
            'image'     => 'required_without:content|nullable|url',
            'content'   => 'required_without:image|nullable|string|max:5000',
            'excerpt'   => 'nullable|string|max:200',
        ]);

        $data = $request->all();

        $post->update($data);
        // $post = Post::create($data);
        $post->tags()->sync($data['tags']);

        return redirect()->route('admin.posts.show', ['post' => $post]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if (Auth::id() != $post->user_id) abort(401);

        $post->delete();

        return redirect()->route('admin.posts.index');
    }
}
