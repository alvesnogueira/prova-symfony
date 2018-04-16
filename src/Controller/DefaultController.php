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
     * @Route("/",name="home_users")
     * @Method({"GET"})
     */
    public function homepage(Request $resquest)
    {
         return $this->render('index.html.twig', [
             'name' => 'teste',
         ]);
    }
    /**
     * @Route("/user/edit/{id}",name="edit_users")
     * @Method({"GET"})
     */
    public function editUser(Request $request,$id)
    {
        $base_url = $request->server->get('HTTP_HOST');
        $users = $this->getDoctrine()
                      ->getRepository(User::class)
                      ->find($id);
        if($users)
        {
            //return $this->redirect($this->generateUrl('home_users', ['users' => $users]));
            return $this->render('index.html.twig', [
                'users' => $users,
                'base_url' => $base_url
            ]);
        }
        else
        {
            $this->addFlash('notice', 'Usuario não localizado');
            return $this->redirect($this->generateUrl('list_users'));
        }

    }
    /**
     * @Route("/endereco/user/edit/{id}")
     * @Method({"POST"})
     */
    public function enderecoUserEdit(Request $request,$id)
    {
        $base_url = $request->server->get('HTTP_HOST');
        $users = $this->getDoctrine()
                      ->getRepository(User::class)
                      ->find($id);
        if($users)
        {
            $this->recebeForm($request, $id);
            return $this->redirect($this->generateUrl('list_users'));
        }
        else
        {
            $this->addFlash('notice', 'Usuario não localizado');
            return $this->redirect($this->generateUrl('list_users'));
        }

    }
    /**
     * @Route("/listar",name="list_users")
     * @Method({"GET"})
     */
    public function listaUser()
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
    public function recebeForm(Request $request, $id = null){
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
            $retorno = $this->savaEndereco($dados, $id);
            if($retorno)
            {
                if($id)
                {
                    $this->addFlash('notice', 'Dados atualizados com sucesso');
                }
                else
                {
                    $this->addFlash('notice', 'Endereço cadastrado com sucesso');
                }
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
    private function savaEndereco($dados, $id = null){
        $entityManager = $this->getDoctrine()->getManager();
        $user = new User();
        $user->setName($dados['nome']);
        $user->setUf($dados['uf']);
        $user->setCidade($dados['cidade']);
        $user->setCep($dados['cep']);
        $user->setBairro($dados['bairro']);
        $user->setLogradouro($dados['logradouro']);
        if($id != null)
        {
            $user->setId($id);
            $entityManager->merge($user);
        }
        else
        {
            $entityManager->persist($user);

        }
        $entityManager->flush();
        return $user->getId();
    }
}
