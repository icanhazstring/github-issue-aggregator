<?php
declare(strict_types=1);

namespace App\Middleware;

use Github\Client;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response;
use Zend\Expressive\Session\Session;
use Zend\Expressive\Session\SessionMiddleware;

class AuthenticationMiddleware implements MiddlewareInterface
{
    public const AUTH_TOKEN = 'auth_token';

    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /** @var Session $session */
        $session = $request->getAttribute(SessionMiddleware::SESSION_ATTRIBUTE);

        if (!$session->has(self::AUTH_TOKEN)) {
            return (new Response())->withStatus(401);
        }

        $this->client->authenticate($session->get(self::AUTH_TOKEN), null, Client::AUTH_HTTP_TOKEN);
        return $handler->handle($request);
    }
}
