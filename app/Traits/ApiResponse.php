<?php
/**
 *
 */

 namespace App\Traits;
trait ApiResponse
{
    public function successResponse($data, $message = null, $code = 200)
    {
        return response()->json(['status'=> 'success', 'message' => 'Successfully Retrieved', 'data'=> $data], $code);
    }

    public function errorResponse($code, $message = null)
    {
        return response()->json(['status'=> 'error', 'message' => $message, 'data'=> null], $code);
    }
}
