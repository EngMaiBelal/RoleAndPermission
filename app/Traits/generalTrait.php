<?php

namespace App\traits;

trait generalTrait {



    public function returnSuccessMessage($message="",$statusCode=200)
    {
        return response()->json(
            [
                'message'=>$message,
                'errors'=>(object)[],
                'data'=>(object)[]
            ],$statusCode);
    }

    public function returnErrorMessage($message="",$statusCode=400)
    {
        return response()->json(
            [
                'message'=>$message,
                'errors'=>(object)[],
                'data'=>(object)[]
            ],$statusCode);
    }



    public function returnData(object $data,$message="",$statusCode = 200)
    {
        return response()->json(
            [
                'message'=>$message,
                'errors'=>(object)[],
                'data'=> $data
            ],$statusCode);
    }


}
