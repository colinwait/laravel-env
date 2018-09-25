## 简单的可视化.env 配置工具

提供简单的.env 配置更改，可保留 env 中的注释项，一键关闭打开注释

### 安装 

```$xslt
composer require colinwait/laravel-env
```

### 初始化

打开 `config/app.php`，将下面配置放至 `providers` 下：

```$xslt
\Colinwait\EnvEditor\EnvEditorProvider::class
```

执行下面的命令，将生成 `config/env-editor.php` 以及 资源页面至项目目录

```$xslt
php artisan vendor:publish --provider="Colinwait\EnvEditor\EnvEditorProvider" 
```

### 配置

```$xslt
<?php
return [
    'route_prefix'     => 'env-editor',
    'route_middleware' => ['env.auth'],
    'env_path'         => base_path('.env'),
    'auth_user'        => '',
    'auth_password'    => ''
];
```
可以设置配置页面的路由前缀、中间件、配置文件路径。

如果需要配置用户密码，可以设置 `auth_user` 和 `auth_password` 

### 起步

当配置都设置好之后，打开 

```$xslt
http://mylaravel.dev/env-editor
```

即可看到对应的界面（虽然略显粗略），如果设置了用户密码，输入用户密码后即可看到页面

### 后期计划

1. 页面美化
2. 支持查看 `.env.example`