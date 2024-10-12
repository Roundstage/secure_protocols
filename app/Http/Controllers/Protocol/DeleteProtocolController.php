<?php

namespace App\Http\Controllers\Protocol;

use App\Http\Controllers\Controller;
use App\Models\Protocol;
use Illuminate\Http\Request;

class DeleteProtocolController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($protocol_id)
    {
        try {
            $protocol = Protocol::findOrFail($protocol_id);
            $protocol->delete();
            return response()->json(['success' => 'Protocol deleted successfully.'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception], 404);
        }
    }
}
