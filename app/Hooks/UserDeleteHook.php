<?php

namespace App\Hooks;

use App\Http\Constants\MicroServicesConstants;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UserDeleteHook extends BaseHook
{
    /**
     * @param $data
     * @return void
     *  a hook to call whenever a delete user is done
     */
    function postUpdates($data)
    {
        $token=$this->createMicroServiceToken([]);
        $urls=MicroServicesConstants::urls();
        foreach ($urls as $key=>$micro_service_url){
            try{
                $response = Http::asForm()->withToken($token)->post($micro_service_url.'', $data);
                Log::info(json_encode($response));
            }catch (\Exception $e){
                Log::error($e->getTraceAsString());
            }
        }
    }
}
