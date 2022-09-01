<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse($result, $message){
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    public function sendError($error, $errorMessage = [], $code){
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if(!empty($errorMessage)){
            $response['data'] = $errorMessage;
        }
        return response()->json($response, $code);
    }
}
