<?php

namespace App\Http\Controllers\v1\User;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use App\Http\Controllers\ApiController;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class MessageController extends ApiController
{

    /**
     * Accessing Location Data.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(){
        $serviceAccount = ServiceAccount::fromArray(config('services.firebase'));
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->create();
        $database = $firebase->getDatabase();
        $ref = $database->getReference('Subjects');
        $key = $ref->push()->getKey();
        $ref->getChild($key)->set([
            'SubjectName' => 'Laravel'
        ]);
        return $key;
    }
}