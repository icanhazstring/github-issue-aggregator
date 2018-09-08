<?php

declare(strict_types=1);

namespace App\Handler;

use App\Middleware\AuthenticationMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Session\SessionInterface;
use Zend\Expressive\Session\SessionMiddleware;
use Zend\Expressive\Template;

class HomePageHandler implements RequestHandlerInterface
{
    private $template;

    public function __construct(Template\TemplateRendererInterface $template)
    {
        $this->template = $template;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var SessionInterface $sesison */
        $session = $request->getAttribute(SessionMiddleware::SESSION_ATTRIBUTE);
        $hasToken = $session->has(AuthenticationMiddleware::AUTH_TOKEN);

        if (!$hasToken) {
            return new HtmlResponse($this->template->render('app::login', [
                'clientId' => $request->getServerParams()['GITHUB_CLIENT_ID'],
            ]));
        }

        return new HtmlResponse($this->template->render('app::home', [
            'hasToken' => $hasToken
        ]));
    }
}
