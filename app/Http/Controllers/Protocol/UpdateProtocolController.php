<?php

namespace App\Http\Controllers\Protocol;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProtocolRequest;
use App\Models\Protocol;
use Illuminate\Http\Request;
use App\Services\ProtocolService;

class UpdateProtocolController extends Controller
{
    protected ProtocolService $protocolService;

    public function __construct(ProtocolService $protocolService)
    {
        $this->protocolService = $protocolService;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke($id_protocol, CreateProtocolRequest $request)
    {
        try {
            $id_protocol = (int)$id_protocol;
            $validatedData = $request->validated();
            $protocol = $this->protocolService->update($id_protocol, $validatedData);
            return response()->json(['success' => 'Protocol updated successfully', 'data' => $protocol], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
