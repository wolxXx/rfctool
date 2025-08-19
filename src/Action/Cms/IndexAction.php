<?php

declare(strict_types=1);

namespace RfcTool\Action\Cms;

#[\RfcTool\Attribute\Action\Route(
    path        : '/',
    methods     : [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
    roles     : \RfcTool\Definition\User\Role::ALL
)]
class IndexAction extends \RfcTool\Action\AbstractAction
{
    use \RfcTool\Action\Share\SimpleRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        if (false === \RfcTool\Util\User\Current::isAuthenticated()) {
            return $this->render(script: 'action/cms/index');
        }

        return $this->render(script: 'action/cms/dashboard');
    }
}
