<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\StoreServiceRequest;
use App\Models\Category;
use App\Models\Service;
use App\Traits\FindTrait;
use App\Traits\GeneralTrait;
use App\Traits\MediaTrait;
use Illuminate\Http\Request;

class AdminServiceController extends Controller
{


    use GeneralTrait , FindTrait , MediaTrait;

    public function store(StoreServiceRequest $request){
        $ServiceData = $request->validated();
        if($request->hasFile('image')) {
            $ServiceData['image'] = $this->saveImg($request, 'services');
        }
        Service::create($ServiceData);
        return $this->returnSuccessMessage('Service Created Successfully');
    }

    public function update(StoreServiceRequest $request, $id){
        $service = $this->servicFinder($id);
        if (!$this->servicFinder($id)) {
            return $this->returnNotFounded($id , 'Service');
        }

        $ServiceData = $request->validated();
        if($request->hasFile('image')) {
            $ServiceData['image'] = $this->saveImg($request, 'services');
        }
        $service->update($ServiceData);
        return $this->returnSuccessMessage('Service Updated Successfully');
    }


    public function destroy($id){
        $service = $this->servicFinder($id);
        if (!$this->servicFinder($id)) {
            return $this->returnNotFounded($id , 'Service');
        }
        $service->delete();
        return $this->returnSuccessMessage('Service Deleted Successfully');
    }

}
