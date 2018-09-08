<?php
declare(strict_types=1);

namespace App\Client;

use App\Client\Plugin\QueryDecodePlugin;
use Github\Client;
use Github\HttpClient\Builder;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class GithubClientFactory
 *
 * @package App\Client
 * @author  icanhazstring <blubb0r05+github@gmail.com>
 */
class GithubClientFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $httpClientBuilder = new Builder();
        $httpClientBuilder->addPlugin(new QueryDecodePlugin());

        return new Client($httpClientBuilder);
    }

}
