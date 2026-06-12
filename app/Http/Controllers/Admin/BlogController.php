<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogImage;
use App\Services\BlogService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    protected $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    /**
     * Display a listing of the blogs.
     */
    public function index()
    {
        $blogs = Blog::with('images')->latest()->get();
        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new blog.
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a newly created blog in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blogs,slug',
            'description' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ]);

        $this->blogService->createBlog($validated);

        return redirect('/admin/blogs')->with('success', 'Blog created successfully.');
    }

    /**
     * Show the form for editing the specified blog.
     */
    public function edit(Blog $blog)
    {
        $blog->load('images');
        return view('admin.blogs.edit', compact('blog'));
    }

    /**
     * Update the specified blog in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blogs,slug,' . $blog->id,
            'description' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ]);

        $this->blogService->updateBlog($blog, $validated);

        return redirect('/admin/blogs')->with('success', 'Blog updated successfully.');
    }

    /**
     * Remove the specified blog from storage.
     */
    public function destroy(Blog $blog)
    {
        $this->blogService->deleteBlog($blog);
        return redirect('/admin/blogs')->with('success', 'Blog deleted successfully.');
    }

    /**
     * Delete an individual blog image via AJAX.
     */
    public function deleteImage(Request $request, $id)
    {
        $image = BlogImage::findOrFail($id);
        $success = $this->blogService->deleteBlogImage($image);

        return response()->json([
            'success' => $success,
            'message' => $success ? 'Image deleted successfully.' : 'Failed to delete image.'
        ]);
    }
}
