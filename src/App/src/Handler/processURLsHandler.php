<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template\TemplateRendererInterface;


class processURLsHandler implements RequestHandlerInterface
{
    /** @var string */
    private $containerName;

    /** @var Router\RouterInterface */
    private $router;


    public function __construct(
        string $containerName,
        Router\RouterInterface $router
    ) {
        $this->containerName = $containerName;
        $this->router        = $router;

    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        
        //get the body of the request 
        $body = $request->getParsedBody();
        //check for our request variable 
        if(!isset($body['urlsToProcess'])){
            //early return if nothing sent 
            $results = json_encode([]);
            return new HtmlResponse(sprintf(
                $results
                ));
        }
        //decode the request variable 
        $urls = json_decode($body['urlsToProcess'], true);
        //initiate results set 
        $results = [];
        //loop through teh urls 
        foreach($urls as $url){
            //sanatize data a bit to prevent javascript attacks;
            $url = htmlspecialchars($url, ENT_HTML5, 'UTF-8');
            //add result to result set 
            $results[$url] = dns_get_record ($url);
            //here i would sanatize the data for entery into the database 
            //here i would add to the database using a model 
        }
       //encode the result set 
        $results = json_encode($results);
        //respond with results 
        return new HtmlResponse(sprintf(
            
            $results
            ));
    }
}
