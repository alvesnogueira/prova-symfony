<?php
namespace App\Controller;

use App\Entity\User;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{

    /**
     * @Route("/")
     * @Method({"GET"})
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
    /**
     * @Route("/endereco/save")
     */
    public function save(){
        $entityManager = $this->getDoctrine()->getManager();
        $user = new User();
        $user->setName('Israel');
        $user->setUf('MG');
        $user->setCidade('Belo Horizonte');
        $user->setCep('31170560');
        $user->setBairro('Uniao');
        $user->setLogradouro('Rua Pedro Jaques');
        $entityManager->persist($user);
        $entityManager->flush();
        return new Response("Salvo".$user->getId());
    }
}
