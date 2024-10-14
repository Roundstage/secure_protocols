<?php

namespace App\Http\Controllers\Protocol;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProtocolRequest;
use App\Models\Protocol;
use Illuminate\Http\Request;

class UpdateProtocolController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($id_protocol, CreateProtocolRequest $request)
    {
        try {
            $id_protocol = (int)$id_protocol;
            $protocol = Protocol::findOrFail($id_protocol);
            $validatedData = $request->validated();

            $protocol->update($validatedData);
            return response()->json(['success' => 'Protocol updated successfully', 'data' => $protocol], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
