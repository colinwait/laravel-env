<?php

namespace Colinwait\EnvEditor;

use Colinwait\EnvEditor\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Facade;

class EnvEditor extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cw-env-editor';
    }
}