<?php

declare(strict_types = 1);
/**
 * @var \Slim\Views\PhpRenderer   $this
 * @var string                    $currentRoute
 * @var string                    $currentRoutePattern
 * @var \RfcTool\Entity\User|null $currentUser
 * @var \RfcTool\Util\ErrorStore  $errorStore
 * @var \RfcTool\Util\Translator  $translator
 */

/**
 * @var string $content
 */

?>

<script src="/js/xdebug.js?v=<?= filemtime(filename: 'public/js/xdebug.js') ?>"></script>

<?= $content ?>