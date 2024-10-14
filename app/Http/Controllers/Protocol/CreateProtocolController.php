<?php

namespace App\Http\Controllers\Protocol;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProtocolRequest;
use App\Models\Protocol;
use App\Services\ProtocolService;
use Illuminate\Http\Request;

class CreateProtocolController extends Controller
{
    protected ProtocolService $protocolService;

    public function __construct(ProtocolService $protocolService)
    {
        $this->protocolService = $protocolService;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateProtocolRequest $request)
    {
        try {
            $protocol = $this->protocolService->create($request->validated());
            return response()->json(['success' => 'Protocol created successfully.', 'data' => $protocol->fresh()], 201);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
