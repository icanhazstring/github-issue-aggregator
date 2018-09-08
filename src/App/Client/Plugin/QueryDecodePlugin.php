<?php
declare(strict_types=1);

namespace App\Client\Plugin;

use Http\Client\Common\Plugin;
use Psr\Http\Message\RequestInterface;

/**
 * Class QueryDecodePlugin
 *
 * @package App\Client\Plugin
 * @author  icanhazstring <blubb0r05+github@gmail.com>
 */
class QueryDecodePlugin implements Plugin
{
    /**
     * @inheritDoc
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first)
    {
        $uri = $request->getUri()->withQuery(
            urldecode($request->getUri()->getQuery())
        );

        return $next($request->withUri($uri));
    }

}
