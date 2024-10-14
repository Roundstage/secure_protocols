<?php

namespace App\Http\Controllers\Protocol;

use App\Http\Controllers\Controller;
use App\Models\Protocol;
use Illuminate\Http\Request;
use App\Services\ProtocolService;

class ListProtocolController extends Controller
{
    protected $protocolService;

    public function __construct(ProtocolService $protocolService)
    {
        $this->protocolService = $protocolService;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $protocols = $this->protocolService->all();
            return response()->json(['success' => 'Protocols successfully fetched', 'data' => $protocols]);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
