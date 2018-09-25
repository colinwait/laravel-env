<?php

namespace Colinwait\EnvEditor\Services;

class EnvService
{
    public $env;

    public function __construct()
    {
        $this->env_path = config('env-editor.env_path');
    }

    public function load($path = '')
    {
        $lines   = $this->readConfig($path);
        $configs = [];
        foreach ($lines as $line) {
            if (strpos($line, '#') === 0) {
                $configs[] = [
                    'type'  => 'note',
                    'key'   => 'note_' . str_random(4),
                    'value' => $line
                ];
                continue;
            }
            $config_arr = explode('=', $line);
            $configs[]  = [
                'type'  => 'config',
                'key'   => trim($config_arr[0]),
                'value' => isset($config_arr[1]) ? trim($config_arr[1]) : null
            ];
        }

        return $configs;
    }

    public function exists($key)
    {
        $lines   = $this->readConfig();
        $configs = [];
        foreach ($lines as $line) {
            if (strpos($line, '#') === 0) {
                continue;
            }
            $config_arr                    = explode('=', $line);
            $configs[trim($config_arr[0])] = isset($config_arr[1]) ? trim($config_arr[1]) : null;
        }

        return key_exists($key, $configs) ? true : false;
    }

    public function readConfig($path = null)
    {
        $path    = $path ?: $this->env_path;
        $configs = file_get_contents($path);

        $lines = array_filter(explode("\n", $configs));

        return $lines;
    }

    public function save($configs, $flag = FILE_TEXT)
    {
        $env_configs = '';
        foreach ($configs as $key => $config) {
            if (strpos($key, 'note_') === 0) {
                $env_configs .= "\n" . $config . "\n";
            } else {
                $env_configs .= $key . '=' . $config . "\n";
            }
        }

        file_put_contents($this->env_path, $env_configs, $flag);
    }
}