<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function listPosts(Request $request)
    {
        $posts = Post::with(['images', 'likes', 'comments.user'])
            ->latest()
            ->paginate(10);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Posts retrieved successfully',
                'posts' => $posts
            ], 200);
        }

        return view('welcome', compact('posts'));
    }

    public function createForm()
    {
        return view('post.post-create');
    }

    public function storePost(Request $request)
    {
        $request->validate([
            'images' => 'required|array|max:12',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'content' => 'required|string|max:255',
        ]);

        $post = new Post();
        $post->content = $request->content;
        $post->user_id = Auth::id();
        $post->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('posts', 'public');
                $post->images()->create(['path' => $imagePath]);
            }
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Post created successfully',
                'post' => $post
            ], 201);
        }

        return redirect()->route('home');
    }

    public function searchForm()
    {
        return view('post.post-search', ['posts' => null]);
    }

    public function searchPosts(Request $request)
    {
        $query = $request->input('query');

        $posts = Post::with(['likes', 'comments'])
            ->where('content', 'like', '%' . $query . '%')
            ->latest()
            ->paginate(10);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Posts retrieved successfully',
                'posts' => $posts
            ], 200);
        }

        return view('post.post-search', compact('posts'));
    }

    public function viewPost(Request $request, $id)
    {
        $post = Post::with(['comments.user', 'likes'])->find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 404);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Post retrieved successfully',
                'post' => $post
            ], 200);
        }

        return view('post.post-detail', compact('post'));
    }

    public function editForm($id)
    {
        $post = Post::with('images')->findOrFail($id);

        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action');
        }

        return view('post.post-edit', compact('post'));
    }

    public function updatePost(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $post->content = $request->input('content');
        $post->save();

        if ($request->has('removed_images')) {
            foreach ($request->input('removed_images') as $imagePath) {
                Storage::delete($imagePath);
                $post->images()->where('path', $imagePath)->delete();
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('post_images');
                $post->images()->create(['path' => $path]);
            }
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Post updated successfully',
                'post' => $post
            ], 200);
        }

        return redirect()->route('posts.detail', $post->id);
    }

    public function storeComment(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $post = Post::findOrFail($postId);

        $comment = $post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Comment added successfully',
                'comment' => $comment
            ], 200);
        }

        return back();
    }

    public function toggleLike(Request $request, $postId)
    {
        $post = Post::findOrFail($postId);
        $user = Auth::user();

        $existingLike = $post->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            $existingLike->delete();
            $status = 'unliked';
        } else {
            $post->likes()->create(['user_id' => $user->id]);
            $status = 'liked';
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Post $status successfully",
                'status' => $status
            ], 200);
        }

        return back();
    }

    public function deletePost(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        if ($post->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        foreach ($post->images as $image) {
            if (Storage::exists('public/' . $image->path)) {
                Storage::delete('public/' . $image->path);
            }
            $image->delete();
        }

        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully'
        ], 200);
    }
}
