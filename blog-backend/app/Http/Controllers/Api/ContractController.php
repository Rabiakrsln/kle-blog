<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContractResource;
use App\Models\Contract;

class ContractController extends Controller
{
    public function show(string $slug)
    {
        $contract = Contract::where('slug', $slug)
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->first();

        abort_unless($contract, 404);

        return new ContractResource($contract);
    }
}