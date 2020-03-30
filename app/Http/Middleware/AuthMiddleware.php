<?php declare(strict_types=1);


namespace App\Http\Middleware;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Http\Server\Contract\MiddlewareInterface;

/**
 * Class AuthMiddleware
 *
 * @package App\Http\Middleware
 *
 * @since 2.0
 *
 * @Bean()
 */
class AuthMiddleware implements MiddlewareInterface
{

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws \Exception
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->getUriPath() === '/favicon.ico') {
            return context()->getResponse()->withStatus(404);
        }

        return $handler->handle($request);
    }
}