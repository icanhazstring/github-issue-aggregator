<?php
declare(strict_types=1);

namespace App\Handler;

use App\Middleware\AuthenticationMiddleware;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Session\SessionInterface;
use Zend\Expressive\Session\SessionMiddleware;

class AuthHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $client = new Client(['base_uri' => 'https://github.com']);
        $response = $client->post('login/oauth/access_token', [
            'headers' => ['Accept' => 'application/json'],
            'json'    => [
                'client_id'     => $request->getServerParams()['GITHUB_CLIENT_ID'],
                'client_secret' => $request->getServerParams()['GITHUB_CLIENT_SECRET'],
                'code'          => $request->getQueryParams()['code']
            ]
        ]);

        $content = \GuzzleHttp\json_decode((string)$response->getBody(), true);

        /** @var SessionInterface $session */
        $session = $request->getAttribute(SessionMiddleware::SESSION_ATTRIBUTE);
        $session->set(AuthenticationMiddleware::AUTH_TOKEN, $content['access_token']);

        return new RedirectResponse('/');
    }

}
