<?php

namespace Saloon\CachePlugin\Drivers;

use Psr\SimpleCache\CacheInterface;
use Saloon\CachePlugin\Contracts\Driver;
use Saloon\CachePlugin\Data\CachedResponse;

/**
 * PSR-16 Cache Driver
 */
class SimpleCacheDriver implements Driver
{
    /**
     * @param CacheInterface $store
     */
    public function __construct(
        protected CacheInterface $store,
    ) {
        //
    }

    /**
     * Store the cached response.
     *
     * @param string $cacheKey
     * @param CachedResponse $response
     * @return void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function set(string $cacheKey, CachedResponse $response): void
    {
        $this->store->set($cacheKey, serialize($response), $response->getExpiry()->diffInSeconds());
    }

    /**
     * Get the cache key from storage
     *
     * @param string $cacheKey
     * @return CachedResponse|null
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function get(string $cacheKey): ?CachedResponse
    {
        $data = $this->store->get($cacheKey, null);

        if (empty($data)) {
            return null;
        }

        return unserialize($data, ['allowed_classes' => true]);
    }

    /**
     * Remove the cached response from storage
     *
     * @param string $cacheKey
     * @return void
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function delete(string $cacheKey): void
    {
        $this->store->delete($cacheKey);
    }
}
