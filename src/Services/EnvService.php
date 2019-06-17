<?php

namespace Colinwait\EnvEditor\Services;

class EnvService
{
    public $env;

    public function __construct()
    {
        $this->env_path = config('env-editor.env_path');
    }

    /**
     * Load Env
     *
     * @param string $path
     *
     * @return array
     */
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

    /**
     * Check if exists
     *
     * @param $key
     *
     * @return bool
     */
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

    /**
     * Load config to array by line
     *
     * @param null $path
     * @param bool $filter
     *
     * @return array
     */
    public function readConfig($path = null, $filter = true)
    {
        $path    = $this->getPath($path);
        $configs = file_get_contents($path);

        $lines = $filter ? array_filter(explode("\n", $configs)) : explode("\n", $configs);

        return $lines;
    }

    /**
     * Save all configs
     *
     * @param     $configs
     * @param int $flag
     */
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

    /**
     * Change configs
     *
     * @param array $configs
     * @param null  $path
     */
    public function change(array $configs, $path = null)
    {
        $env_configs = $this->readConfig($path, false);

        $env_replace_configs = '';
        foreach ($env_configs as $env_config) {
            foreach ($configs as $key => $value) {
                preg_match('/^\s?' . $key . '\s?=\s?(.*)?/', $env_config, $matches);
                if (!empty($matches)) {
                    $match_key   = $key;
                    $match_value = $value;
                }
            }
            if (!isset($match_key, $match_value)) {
                $env_replace_configs .= $env_config . PHP_EOL;
                continue;
            }
            $env_replace_configs .= ($match_key . '=' . $match_value . PHP_EOL);
            unset($match_key, $match_value);
        }

        file_put_contents($this->getPath($path), $env_replace_configs);
    }

    /**
     * Get Env path
     *
     * @param null $path
     *
     * @return |null
     */
    private function getPath($path = null)
    {
        $path = $path ?: $this->env_path;

        return $path;
    }
}