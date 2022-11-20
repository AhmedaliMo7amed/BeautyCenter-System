<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoriesResource;
use App\Http\Resources\ProvWithoutTokenResource;
use App\Http\Resources\SubCategoriesResource;
use App\Models\Category;
use App\Traits\FindTrait;
use App\Traits\GeneralTrait;
use App\Traits\MediaTrait;

class CategoryController extends Controller
{
    use GeneralTrait , MediaTrait , FindTrait;

    public function allCategories(){
        $result = CategoriesResource::collection(Category::with('subCategory')->whereHas('subCategory')->get());
        return $this->returnData('Data' , $result , 'All Categories Sended');
    }

    public function subCategories(){
        $result = SubCategoriesResource::collection(Category::where('parent_id' , '!=' , Null)->get());
        return $this->returnData('Data' , $result , 'All Sub-Categories Sended');
    }

    public function getCategory($id){
        $category = $this->CategoryFinder($id);
        if (!$this->CategoryFinder($id)) {
            return $this->returnNotFounded($id , 'Category');
        }
        return $this->returnData('Data' , new CategoriesResource($category) , 'Category Sended');
    }

    public function categoryProviders($id){
        $category = $this->CategoryFinder($id);
        if (!$this->CategoryFinder($id)) {
            return $this->returnNotFounded($id , 'Category');
        }

        return $this->returnData('Data' , ProvWithoutTokenResource::collection($category->providers()->get()) , 'Category Sended');
    }

}
