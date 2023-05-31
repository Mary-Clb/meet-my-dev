<?php

namespace App\Controller;

use Exception;
use Throwable;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ErrorController extends AbstractController
{
    public function showException(Throwable $exception)
    {
        $statusCode = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : 500;

        if (in_array($statusCode, [404])) {
            $template = 'errors/' . $statusCode . '.html.twig';
        }else{
            $template = 'errors/error.html.twig';
        }

        $content = $exception->getMessage();
        return new Response(
        $this->container->get('twig')->render(
            $template,
            ['exception' => $exception->__toString(), 'status_code' => $statusCode, 'status_text' => Response::$statusTexts[$statusCode], 'content' => $content]
        ),
        $statusCode);
    }
}