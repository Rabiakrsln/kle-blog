<?php

namespace App\Http\Controllers;

use App\Services\BackendApiService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct(
        protected BackendApiService $api
    ) {
    }

    public function show()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $response = $this->api->login(
            $validated['email'],
            $validated['password']
        );

        if (!$response->successful()) {
            return back()
                ->withErrors([
                    'login' => $response->json(
                        'message',
                        'E-posta veya şifre hatalı.'
                    ),
                ])
                ->withInput($request->only('email'));
        }

        $token = $response->json('token');

        if (!$token) {
            return back()
                ->withErrors([
                    'login' => 'Giriş başarılı ancak token alınamadı.',
                ])
                ->withInput($request->only('email'));
        }

        $request->session()->regenerate();

        $request->session()->put('api_token', $token);

        return redirect('/dashboard');
    }

    public function logout(Request $request)
    {
        $token = $request->session()->get('api_token');

        if ($token) {
            $this->api->logout($token);
        }

        $request->session()->forget('api_token');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}