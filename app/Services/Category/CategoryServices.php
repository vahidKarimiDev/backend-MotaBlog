<?php

namespace App\Services\Category;

use App\Base\ServiceResult;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery\Exception\BadMethodCallException;

class CategoryServices
{


    public function getAllCategory(): ServiceResult
    {
        try {
            $categories = Category::all();
        } catch (\Throwable $err) {
            return new ServiceResult(ok: false, data: $err->getMessage(), status: 500);
        }
        return new ServiceResult(ok: true, data: $categories, status: 200);
    }


    public function createNewCategory($data): ServiceResult
    {
        try {
            $result = Category::create($data);
        } catch (\Throwable $err) {
            return new ServiceResult(ok: false, data: $err->getMessage(), status: 500);
        }
        return new ServiceResult(ok: true, data: $result, status: 201);
    }

    public function updateCategory($data, string $id): ServiceResult
    {
        try {
            $category = Category::findOrFail($id);
            $category->update($data);
        } catch (ModelNotFoundException $err) {
            return new ServiceResult(ok: false, data: "Category Not A Found :(", status: 404);
        } catch (\Throwable $err) {
            return new ServiceResult(ok: false, data: $err->getMessage(), status: 500);
        }
        return new ServiceResult(ok: true, data: $category, status: 200);
    }

    public function deleteCategory(string $id): ServiceResult
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
        } catch (ModelNotFoundException) {
            return new ServiceResult(ok: false, data: "Category Not A Found :(", status: 404);
        } catch (\Throwable $err) {
            return new ServiceResult(ok: false, data: $err->getMessage(), status: 500);
        }
        return new ServiceResult(ok: true, data: [], status: 204);
    }


}
