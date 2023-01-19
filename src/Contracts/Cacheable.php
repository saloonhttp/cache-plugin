<?php

namespace Saloon\CachePlugin\Contracts;

interface Cacheable
{
    /**
     * Resolve the driver responsible for caching
     *
     * @return \Saloon\CachePlugin\Contracts\Driver
     */
    public function resolveCacheDriver(): Driver;

    /**
     * Define the cache expiry in seconds
     *
     * @return int
     */
    public function defineCacheExpiry(): int;
}
