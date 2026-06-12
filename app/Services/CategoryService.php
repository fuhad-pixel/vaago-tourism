<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\File;

class CategoryService
{
    /**
     * Get all categories with parent category information.
     */
    public function getAllCategories()
    {
        return Category::with('parent')->latest()->get();
    }

    /**
     * Get candidates for parent category.
     * Excludes the category itself to prevent direct cyclic relationship.
     */
    public function getParentCandidates($excludeId = null)
    {
        $query = Category::query();
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        return $query->orderBy('name', 'asc')->get();
    }

    /**
     * Create a new category.
     */
    public function createCategory(array $data): Category
    {
        $imagePath = null;
        if (isset($data['image']) && $data['image']->isValid()) {
            $imagePath = $this->uploadImage($data['image']);
        }

        return Category::create([
            'name' => $data['name'],
            'parent_id' => $data['parent_id'] ?? null,
            'description' => $data['description'] ?? null,
            'image' => $imagePath,
        ]);
    }

    /**
     * Update an existing category.
     */
    public function updateCategory(Category $category, array $data): Category
    {
        $updateData = [
            'name' => $data['name'],
            'parent_id' => $data['parent_id'] ?? null,
            'description' => $data['description'] ?? null,
        ];

        if (isset($data['image']) && $data['image']->isValid()) {
            // Delete old image if it exists
            $this->deleteImageFile($category->image);
            $updateData['image'] = $this->uploadImage($data['image']);
        }

        $category->update($updateData);

        return $category;
    }

    /**
     * Soft delete a category.
     */
    public function deleteCategory(Category $category): bool
    {
        // Keep image file intact in case of restore, or delete it?
        // With soft deletes, usually files are kept. If they force delete, we can delete the image file.
        return $category->delete();
    }

    /**
     * Upload category image.
     */
    protected function uploadImage($file): string
    {
        $uploadPath = public_path('uploads/categories');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($uploadPath, $filename);

        return 'uploads/categories/' . $filename;
    }

    /**
     * Delete image file helper.
     */
    protected function deleteImageFile($path): void
    {
        if ($path) {
            $fullPath = public_path($path);
            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }
        }
    }
}
