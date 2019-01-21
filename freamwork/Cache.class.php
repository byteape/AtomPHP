<?php

namespace freamwork;


use Cache\Adapter\Filesystem\FilesystemCachePool;
use Cache\Adapter\Redis\RedisCachePool;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Redis;

/**
 * 缓存处理
 * Class Cache
 * @package freamwork
 */
class Cache {

    /**
     * 获取缓存引擎
     * @return FilesystemCachePool|RedisCachePool
     */
    private static function getDriver() {
        $cache_driver = config('CACHE_DRIVER');
        switch ($cache_driver) {
            case 'file':
                $filesystemAdapter = new Local(__DIR__ . '/../runtime/');
                $filesystem        = new Filesystem($filesystemAdapter);
                $cacheDriver       = new FilesystemCachePool($filesystem);
                break;
            case 'redis':

                $client = new Redis();
                $client->connect(getenv('REDIS_URI'), getenv('REDIS_PORT'));
                $client->select(getenv('REDIS_DB'));
                $cacheDriver = new RedisCachePool($client);
                break;
        }
        return $cacheDriver;
    }

    /**
     * 获取缓存数据
     * @param $id
     * @return mixed|null|void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function get($id) {
        $cacheDriver = self::getDriver();
        return $cacheDriver->get($id);
    }

    /**
     * 是否存在缓存数据
     * @param $id
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function has($id) {
        $cacheDriver = self::getDriver();
        return $cacheDriver->has($id);
    }

    /**
     * 存储缓存
     * @param $id
     * @param $data
     * @param int $lifeTime
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function set($id, $data, $lifeTime = 0) {
        $cacheDriver = self::getDriver();
        return $cacheDriver->set($id, $data, $lifeTime);
    }

    /**
     * 删除缓存
     * @param $id
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function delete($id) {
        $cacheDriver = self::getDriver();
        return $cacheDriver->delete($id);
    }

    /**
     * 获取与设置缓存
     * @param $id
     * @param $data
     * @param $lifeTime
     * @return mixed|null|void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function remember($id, $data, $lifeTime) {
        if (!self::has($id)) {
            self::set($id, $data, $lifeTime);
        }
        return self::get($id);
    }
}