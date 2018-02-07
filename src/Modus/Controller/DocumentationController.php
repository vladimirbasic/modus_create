<?php

declare(strict_types=1);

namespace Modus\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

class DocumentationController
{
    /**
     * @var
     */
    private $twig;

    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    public function get(): Response
    {
        $headers = ['Content-Type' => CONTENT_TYPE_HTML];
        return new Response($this->twig->render('Documentation/doc.html'), Response::HTTP_OK, $headers);
    }
}
