<?php

declare(strict_types=1);

namespace RfcTool\Action\Auth;

#[\RfcTool\Attribute\Action\Route(
    path        : '/auth/login',
    methods     : [
        \Fig\Http\Message\RequestMethodInterface::METHOD_GET,
    ],
    roles     : \RfcTool\Definition\User\Role::ALL
)]
class LoginAction extends \RfcTool\Action\AbstractAction
{
    use \RfcTool\Action\Share\SimpleRoute;

    public function run(): \Psr\Http\Message\ResponseInterface
    {
        \RfcTool\Util\Debugger::dieDebug('jaja');
    }
}
