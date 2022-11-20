<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use App\Traits\FindTrait;
use App\Traits\GeneralTrait;
use App\Traits\MediaTrait;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    use GeneralTrait , FindTrait , MediaTrait;

    public function store(StoreCategoryRequest $request){
        $CategoryData = $request->validated();
        if($request->hasFile('image')) {
            $CategoryData['image'] = $this->saveImg($request, 'categories');
        }
        Category::create($CategoryData);
        return $this->returnSuccessMessage('Category Created Successfully');
    }

    public function update(StoreCategoryRequest $request, $id){
        $category = $this->CategoryFinder($id);
        if (!$this->CategoryFinder($id)) {
            return $this->returnNotFounded($id , 'Category');
        }

        $CategoryData = $request->validated();
        if($request->hasFile('image')) {
            $CategoryData['image'] = $this->saveImg($request, 'categories');
        }
        $category->update($CategoryData);
        return $this->returnSuccessMessage('Category Updated Successfully');
    }


    public function destroy($id){
        $category = $this->CategoryFinder($id);
        if (!$this->CategoryFinder($id)) {
            return $this->returnNotFounded($id , 'Category');
        }
        $category->delete();
        return $this->returnSuccessMessage('Category Deleted Successfully');
    }

}
