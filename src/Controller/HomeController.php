<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{ 
    public function homepage(): Response
    {        
        return $this->render('/home/home.html.twig', [
            'name' => 'nicholas',
        ]);
    }
}