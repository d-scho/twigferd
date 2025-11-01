<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

final readonly class IndexController
{
    #[Route('/', methods: ['GET'])]
    public function __invoke(Environment $twig): Response
    {
        $html = $twig->render('index.html.twig');

        return new Response($html);
    }
}
