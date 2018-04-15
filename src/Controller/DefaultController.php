<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{

    /**
     * @Route("/")
     */
    public function homepage()
    {
         return $this->render('index.html.twig', [
             'name' => 'teste',
         ]);
       // return new Response(
       //      '<html><body>Lucky number: </body></html>'
       //  );
    }


}
