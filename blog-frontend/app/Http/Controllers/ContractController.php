<?php

namespace App\Http\Controllers;

use App\Services\BackendApiService;

class ContractController extends Controller
{
    public function __construct(
        protected BackendApiService $api
    ) {
    }

    public function show()
    {
        $slug = 'kullanim-kosullari';

        $response = $this->api->getContract($slug);

        abort_unless($response->successful(), 404);

        $contract = $response->json('data');

        return view('contract', compact('contract'));
    }
}