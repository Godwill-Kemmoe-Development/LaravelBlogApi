<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogPostController extends Controller
{
    public function index()
    {
        // Fetch and return the list of blog posts
        $posts = BlogPost::all();
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'content' => 'required',
            'author' => 'required|max:255',
            'status' => 'in:draft,published'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $post = BlogPost::create($request->all());
        return response()->json($post, 201);
    }

    public function show($id)
    {
        $post = BlogPost::find($id);
        if (is_null($post)) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        return response()->json($post);
    }

    public function update(Request $request, $id)
    {
        $post = BlogPost::find($id);
        if (is_null($post)) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|max:255',
            'content' => 'sometimes|required',
            'author' => 'sometimes|required|max:255',
            'status' => 'in:draft,published'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $post->update($request->all());

        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = BlogPost::find($id);
        if (is_null($post)) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $post->delete();

        return response()->json(null, 204);
    }
}
