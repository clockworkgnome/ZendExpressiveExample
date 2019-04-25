<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Expressive\Twig\TwigRenderer;


class getDnsByStringHandler implements RequestHandlerInterface
{
    /** @var string */
    private $containerName;
    
    /** @var Router\RouterInterface */
    private $router;
    
    /** @var null|TemplateRendererInterface */
    private $template;
    
    public function __construct(
        string $containerName,
        Router\RouterInterface $router,
        ?TemplateRendererInterface $template = null
        ) {
            $this->containerName = $containerName;
            $this->router        = $router;
            $this->template      = $template;
    }
    
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        
        $target = $request->getQueryParams()['target'] ?? 'World';
        $target = htmlspecialchars($target, ENT_HTML5, 'UTF-8');
        $target= $request->getParsedBody();
        $target = json_encode($target);
        return new HtmlResponse($this->template->render('app::get-dns-by-string', ['target' => $target]));
    }
}
