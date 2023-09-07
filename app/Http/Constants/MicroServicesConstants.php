<?php

namespace App\Http\Constants;

class MicroServicesConstants
{
    public static function urls(){
        return [
            'user_micro_service'        => env('USER_SITE_URL','http://localhost:5000/hooks/users'),
            'course_micro_service'      => env('COURSE_SITE_URL','http://localhost:6000/hooks/courses'),
            'appointment_micro_service' => env('APPOINTMENT_SITE_URL','http://localhost:7000/hooks/appointments'),
        ];

    }

    public static function currentMicroServiceUrl(){
        return env('CURRENT_MICRO_SERVICE','http://localhost:5000/hooks/users');
    }
}
