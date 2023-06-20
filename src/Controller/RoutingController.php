<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/routing', name: 'routing_')]
class RoutingController extends AbstractController
{
    /**
     * @return Response
     * This route only works with get route
     */
    #[Route(
        '/match_expression/{id}',
        name: 'match_expression',
        requirements: ['id' => '\d+'],
        defaults: ["id" => 1],
        condition: "context.getMethod() in ['GET', 'HEAD'] and params['id'] < 1000"
    )]
    public function matchExpression(int $id): Response
    {
        return $this->render('routing/match_expression.html.twig');
    }


    #[Route(
        '/match_expression/first-priority',
        priority: 1
    )]
    public function priorityParameter(): Response
    {
        return $this->render('routing/priority_parameter.html.twig');
    }


    #[Route(
        '/special_parameters',
        name: 'special_parameters',
        requirements: [
            '_locale' => 'en|fr',
            '_format' => 'html|xml',
            '_fragment' => 'name'
        ],
        locale: 'en',
        format: 'html',
    )]
    public function specialParameters(): Response
    {
        return $this->render('routing/special_parameters.html.twig');
    }


    #[Route(
        '/slash_parameters/{token}',
        name: 'slash_parameters',
        requirements: ['token' => '.+'],
        defaults: ['token' => 'hello/there']
    )]
    public function slashParameters($token): Response
    {
        return $this->render('routing/slash_parameters.html.twig', [
            'token' => $token
        ]);
    }


    #[Route(
        '/sub_domain',
        name: 'sub_domain',
        host: 'classified.com'
    )]
    public function subDomain(): Response
    {
        return $this->render('routing/sub_domain.html.twig');
    }
}
