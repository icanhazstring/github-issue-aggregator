<?php
declare(strict_types=1);

namespace App\Handler;

use App\Service\GithubService;
use App\Service\PackagistService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template;

class RepositoryHandler implements RequestHandlerInterface
{
    private $template;
    private $githubService;
    private $packagistService;

    public function __construct(
        Template\TemplateRendererInterface $template,
        GithubService $githubService,
        PackagistService $packagistService
    ) {
        $this->template = $template;
        $this->githubService = $githubService;
        $this->packagistService = $packagistService;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $owner = $request->getAttribute('owner');
        $repository = $request->getAttribute('repo');

        $requirements = $this->githubService->getRootRequirements($owner, $repository);
        $repositories = $this->packagistService->resolveRepositories($requirements);

        return new HtmlResponse($this->template->render('app::issues', []));
    }

}
