<?php

namespace App\Http\Controllers\Protocol;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProtocolRequest;
use App\Models\Protocol;
use Illuminate\Http\Request;

class CreateProtocolController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateProtocolRequest $request)
    {
        try {
            $protocol = new Protocol($request->validated());
            $protocol->save();
            return response()->json(['success' => 'Protocol created successfully.', 'protocol'=>$protocol->fresh()], 201);
        }catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
