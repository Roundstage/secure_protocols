<?php

namespace App\Http\Controllers\Protocol;

use App\Http\Controllers\Controller;
use App\Services\ProtocolService;
use Illuminate\Http\Request;

class DeleteProtocolController extends Controller
{
    protected ProtocolService $protocolService;

    public function __construct(ProtocolService $protocolService)
    {
        $this->protocolService = $protocolService;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke($protocol_id)
    {
        try {
            $this->protocolService->delete($protocol_id);
            return response()->json(['success' => 'Protocol deleted successfully.'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception], 404);
        }
    }
}
