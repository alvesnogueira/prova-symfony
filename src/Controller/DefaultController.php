<?php
namespace App\Controller;

use App\Entity\User;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
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
    }
    /**
     * @Route("/listar",name="list_users")
     * @Method({"GET"})
     */
    public function listaDados()
    {
        $users = $this->getDoctrine()
                 ->getRepository(User::class)
                 ->findAll();

        return $this->render('lista.html.twig', [
            'users' => $users,
        ]);

    }

    /**
     * @Route("/user/delete/{id}")
     * @Method({"GET"})
     */
    public function deleteUser(Request $request, $id)
    {
        $users = $this->getDoctrine()
                 ->getRepository(User::class)
                 ->find($id);
        if($users)
        {
            $entityManager = $this->getDoctrine()->getManager();
            $delete = $entityManager->remove($users);
            $entityManager->flush();
            $this->addFlash('notice', 'Usuario excluido com sucesso');
        }
        else
        {
            $this->addFlash('notice', 'Usuario não cadastrado');
        }
        //return $this->redirect($this->generateUrl('list_users', array('id' => $entity->getId())));
        return $this->redirect($this->generateUrl('list_users'));

    }
    /**
     * @Route("/endereco/save")
     */
    public function recebeForm(Request $request){
        $erros = [];
        if($request->get('nome') == '')
        {
            $erros['nome'] = 'Informe o nome';
        }
        if($request->get('uf') == '')
        {
            $erros['uf'] = 'Informe a UF';
        }
        if($request->get('cidade') == '')
        {
            $erros['cidade'] = 'Informe a cidade';
        }
        if($request->get('cep') == '')
        {
            $erros['cep'] = 'Informe o bairro';
        }

        if(count($erros) > 0)
        {
            $this->addFlash('notice','Preencha todos os campos obrigatorios');
        }
        else
        {
            $dados = [];
            $cep = str_replace(array('-', '.', ' ','_', '(', ')'), '', $request->get('cep'));
            $dados['nome'] = $request->get('nome');
            $dados['uf'] = $request->get('uf');
            $dados['cidade'] = $request->get('cidade');
            $dados['cep'] = $cep;
            $dados['bairro'] = $request->get('bairro');
            $dados['logradouro'] = $request->get('logradouro');
            $retorno = $this->saveEndereco($dados);
            if($retorno)
            {
                $this->addFlash('notice', 'Endereço cadastrado com sucesso');
            }
            else
            {
                $this->addFlash('notice', 'Algo deu errado, por favor tente novamente mais tarde.');
            }
        }


        //return $this->redirect($this->generateUrl('vo_show', array('id' => $entity->getId())));
        return $this->redirect('/');

    }

    /**
     *
     */
    private function saveEndereco($dados){
        $entityManager = $this->getDoctrine()->getManager();
        $user = new User();
        $user->setName($dados['nome']);
        $user->setUf($dados['uf']);
        $user->setCidade($dados['cidade']);
        $user->setCep($dados['cep']);
        $user->setBairro($dados['bairro']);
        $user->setLogradouro($dados['logradouro']);
        $entityManager->persist($user);
        $entityManager->flush();
        return $user->getId();
    }
}
