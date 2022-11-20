<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllServicesResource;
use App\Http\Resources\CategoriesResource;
use App\Http\Resources\ProvWithoutTokenResource;
use App\Http\Resources\ProviderServicesResource;
use App\Http\Resources\ServiceProvidersResource;
use App\Http\Resources\SubCategoriesResource;
use App\Http\Resources\SubServicesResource;
use App\Models\Category;
use App\Models\ProviderService;
use App\Models\Service;
use App\Models\User;
use App\Traits\FindTrait;
use App\Traits\GeneralTrait;
use App\Traits\MediaTrait;
use Illuminate\Http\Request;

class ServicesController extends Controller
{

    use GeneralTrait , MediaTrait , FindTrait;

    public function allServices(){
        return $this->returnData('Data' ,
                                  AllServicesResource::collection(Service::whereHas('subService')->with('subService')->get())
                                 , 'All Services Sent');
    }

    public function subServices(){
        $result = SubServicesResource::collection(Service::where('parent_id' , '!=' , Null)->get());
        return $this->returnData('Data' , $result , 'All Sub-Services Sent');
    }

    public function getService($id){
        $service = $this->servicFinder($id);
        if (!$this->servicFinder($id)) {
            return $this->returnNotFounded($id , 'Service');
        }
        return $this->returnData('Data' , new SubServicesResource($service) , 'Service Sent');
    }

    public function serviceProviders($id){
        $service = $this->servicFinder($id);
        if (!$this->servicFinder($id)) {
            return $this->returnNotFounded($id , 'Service');
        }
        $data= ProviderService::with('provider')->where('service_id',$id)->get()->pluck('provider')->unique('id');
        return $this->returnData('Data' , ServiceProvidersResource::collection($data) , 'Providers Sent');
    }

    public function providerServices($id)
    {
        $provider = $this->providerFinder($id);
        if (!$this->providerFinder($id)) {
            return $this->returnNotFounded($id , 'Provider');
        }
        return $this->returnData('Data' ,  new ProvWithoutTokenResource($provider) , 'Provider & Services Sended');
    }
}
