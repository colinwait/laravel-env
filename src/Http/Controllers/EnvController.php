<?php

namespace Colinwait\EnvEditor\Http\Controllers;

use Colinwait\EnvEditor\Services\AuthService;
use Colinwait\EnvEditor\Services\EnvService;
use Illuminate\Routing\Controller;

class EnvController extends Controller
{
    private $envService;

    private $authService;

    public function __construct(EnvService $envService, AuthService $authService)
    {
        $this->envService  = $envService;
        $this->authService = $authService;

    }

    public function index()
    {
        $env_array = $this->envService->load();

        $vars = [
            'configs'  => $env_array,
            'user'     => $this->authService->getUser(),
            'password' => $this->authService->getPassword(),
        ];

        return view('env-editor::env', $vars);
    }

    public function store()
    {
        $configs = array_except(request()->all(), ['user', 'password']);

        $this->envService->save($configs);

        return redirect()->back();
    }

    public function append()
    {
        $key = trim(request('key'));
        if ($this->envService->exists($key)) {
            return $this->index();
        }
        $configs = [$key => trim(request('value'))];

        $this->envService->save($configs, FILE_APPEND);

        return redirect()->back();
    }
}