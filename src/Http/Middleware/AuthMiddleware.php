<?php

namespace Colinwait\EnvEditor\Http\Middleware;

use Closure;
use Colinwait\EnvEditor\Services\AuthService;

class AuthMiddleware
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$this->authService->verify($this->authService->getUser(), $this->authService->getPassword())) {
            return view('env-editor::auth');
        }

        return $next($request);
    }
}