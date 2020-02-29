<?php


namespace App;


use Exception;

class Config
{
    /**
     * @var array
     */
    private $config = [];

    /**
     * Config constructor.
     * @param string $main_config_path
     * @param string $default_configs_path
     * @throws Exception
     */
    public function __construct(string $main_config_path, string $default_configs_path)
    {
        $config = $this->parseConfigDir($default_configs_path);

        if (file_exists($main_config_path) && !is_dir($main_config_path)) {
            $main_config = require $main_config_path;
        } else {
            throw new Exception('Main config not defined');
        }

        $this->config = array_replace_recursive($config, $main_config);
    }

    /**
     * @param string $path
     * @param string $delimiter
     *
     * @return array|null
     */
    public function get(string $path, string $delimiter = '.')
    {
        $path = explode($delimiter, $path);

        $result = $this->config;

        foreach ($path as $path_item) {
            if (isset($result[$path_item])) {
                $result = $result[$path_item];
            } else {
                $result = null;
                break;
            }
        }

        return $result;
    }

    /**
     * @param string $config_dir_path
     * @return array
     */
    private function parseConfigDir(string $config_dir_path):array
    {
        if (!is_dir($config_dir_path)) {
            return [];
        }

        $config_dir_path = realpath($config_dir_path);
        $default_config_paths = glob($config_dir_path . '/*', GLOB_MARK);

        $config = [];
        foreach ($default_config_paths as $path) {
            $path_info = pathinfo($path);
            $key = $path_info['filename'];

            if (is_dir($path)) {
                $result = $this->parseConfigDir($path);
            } else {
                try {
                    $result = require $path;
                } catch (Exception $e) {
                    $result = null;
                }
            }

            $config[$key] = $result;
        }

        return $config;
    }
}