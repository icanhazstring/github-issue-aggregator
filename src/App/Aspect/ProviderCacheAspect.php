<?php
declare(strict_types=1);

namespace App\Aspect;

use Doctrine\Common\Cache\CacheProvider;
use Go\Aop\Aspect;
use Go\Aop\Intercept\MethodInvocation;
use Go\Lang\Annotation\Around;

/**
 * Provider caching aspect
 */
class ProviderCacheAspect implements Aspect
{
    private $cache;

    public function __construct(CacheProvider $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Cache execution of provider
     *
     * @param MethodInvocation $invocation
     * @Around("execution(public App\Provider\*Provider->load*(*))")
     * @return mixed
     */
    public function beforeMethod(MethodInvocation $invocation)
    {
        $arguments = $this->fetchArguments($invocation);

        $invocationClass = str_replace('\\', '-', \get_class($invocation->getThis()));
        $cacheKey = $invocationClass . '-' . $invocation->getMethod()->getName() . '-' . $arguments;

        $cacheKey = strtolower($cacheKey);

        if (!$this->cache->contains($cacheKey)) {
            $this->cache->save($cacheKey, $invocation->proceed());
        }

        return $this->cache->fetch($cacheKey);
    }

    /**
     * Fetch invocation arguments
     *
     * @param MethodInvocation $invocation
     * @return string
     */
    protected function fetchArguments(MethodInvocation $invocation): string
    {
        $arguments = $invocation->getArguments();
        $arguments = array_map(function ($argument) {
            if (\is_array($argument)) {
                $argument = implode('', $argument);
            }

            return $argument;
        }, $arguments);

        return implode('', $arguments);
    }
}
