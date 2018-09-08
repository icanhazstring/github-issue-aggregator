<?php
declare(strict_types=1);

namespace App\Handler;

use App\Service\GithubService;
use App\Service\PackagistService;
use App\Utils\RepositoryUtils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template;

/**
 * Class RepositoryHandler
 *
 * @package App\Handler
 * @author  icanhazstring <blubb0r05+github@gmail.com>
 */
class RepositoryHandler implements RequestHandlerInterface
{
    private $template;
    private $githubService;
    private $packagistService;
    private $repositoryUtils;

    public function __construct(
        Template\TemplateRendererInterface $template,
        GithubService $githubService,
        PackagistService $packagistService,
        RepositoryUtils $repositoryUtils
    ) {
        $this->template = $template;
        $this->githubService = $githubService;
        $this->packagistService = $packagistService;
        $this->repositoryUtils = $repositoryUtils;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $owner = $request->getAttribute('owner');
        $repository = $request->getAttribute('repo');

        $requirements = $this->githubService->getRootRequirements($owner, $repository);

        $repositories = $this->packagistService->resolveRepositories($requirements);
        $this->githubService->loadIssuesForRepositories($repositories);
        $rootRepository = array_shift($repositories);
//
//        $r = new Repository();
//        $r->setName('fubar/package');
//        $r->setPackageName('test/package');
//        $r->setIssues(array_fill(1, 20, 'a'));
//        $r->setUrl('https://github.com/test/package');
//        $rootRepository = $r;
//        $repositories = [];

        return new HtmlResponse($this->template->render('app::issues', [
            'rootRepository' => $rootRepository,
            'repositories'   => $this->repositoryUtils->sortByLevenshteinDistance(
                $rootRepository->getName(), $repositories
            )
        ]));
    }
}
