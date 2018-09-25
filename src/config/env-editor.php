<?php
return [
    'route_prefix'     => 'env-editor',
    'route_middleware' => ['env.auth'],
    'env_path'         => base_path('.env'),
    'auth_user'        => '',
    'auth_password'    => ''
];