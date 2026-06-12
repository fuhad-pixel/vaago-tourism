<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\BlogImage;
use Illuminate\Support\Facades\File;

class BlogService
{
    /**
     * Store a new blog and its images.
     */
    public function createBlog(array $data): Blog
    {
        $blog = Blog::create([
            'title' => $data['title'],
            'slug' => $data['slug'],
            'description' => $data['description'] ?? null,
        ]);

        if (isset($data['images']) && is_array($data['images'])) {
            $this->uploadBlogImages($blog, $data['images']);
        }

        return $blog;
    }

    /**
     * Update an existing blog and its images.
     */
    public function updateBlog(Blog $blog, array $data): Blog
    {
        $blog->update([
            'title' => $data['title'],
            'slug' => $data['slug'],
            'description' => $data['description'] ?? null,
        ]);

        if (isset($data['images']) && is_array($data['images'])) {
            $this->uploadBlogImages($blog, $data['images']);
        }

        return $blog;
    }

    /**
     * Soft delete a blog post.
     */
    public function deleteBlog(Blog $blog): bool
    {
        return $blog->delete();
    }

    /**
     * Upload and associate multiple images for a blog.
     */
    protected function uploadBlogImages(Blog $blog, array $images): void
    {
        $uploadPath = public_path('uploads/blogs');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        foreach ($images as $index => $file) {
            if ($file->isValid()) {
                $filename = time() . '_' . $index . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($uploadPath, $filename);
                
                BlogImage::create([
                    'blog_id' => $blog->id,
                    'image_path' => 'uploads/blogs/' . $filename,
                ]);
            }
        }
    }

    /**
     * Delete an individual blog image (AJAX or direct edit action).
     */
    public function deleteBlogImage(BlogImage $image): bool
    {
        $filePath = public_path($image->image_path);
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
        return $image->delete();
    }
}
