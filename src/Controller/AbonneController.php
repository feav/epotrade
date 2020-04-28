<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\InformationRepository;
use App\Repository\UserRepository;
use App\Entity\User;
use App\Entity\Information;

class AbonneController extends AbstractController
{ 
	private $informationRepository;
	private $userRepository;
	private $params;
	public function __construct(Security $security, InformationRepository $informationRepository, UserRepository $userRepository, ParameterBagInterface $params)
    {
        $this->security = $security;
        $this->userRepository = $userRepository;
        $this->informationRepository = $informationRepository;
        $this->params = $params;
    }

	public function listAbonne(Request $request)
    {
    	$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
    	$user = $this->security->getUser();
    	if($user->getRole() == 1)
    		return $this->redirectToRoute('inscription_home');
		
    	$users = $this->userRepository->findBy(['role'=>1]);
		return $this->render('backoffice/abonne_list.html.twig', ['users'=>$users]);
	}	
	public function infosAbonne(Request $request, $id)
    {
    	$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
    	$user = $this->security->getUser();
    	if($user->getRole() == 1)
    		return $this->redirectToRoute('inscription_home');
		
    	$informations = $this->informationRepository->findOneBy(['user'=>$id]);
		return $this->render('backoffice/abonne_infos.html.twig', ['informations'=>$informations]);
	}	
	public function UpdateToCreate(Request $request, $id)
    {	
    	$em = $this->getDoctrine()->getManager();
    	$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
    	$user = $this->security->getUser();
    	if($user->getRole() == 1)
    		return $this->redirectToRoute('inscription_home');
		
    	$information = $this->informationRepository->findOneBy(['user'=>$id]);
    	$information->setIsCreate(true);
    	$em->flush();
    	$this->addFlash("success", "L'abonné est maintenant crée");
		return $this->redirectToRoute('informations_abonne', ['id'=>$id]);
	}

    /**
     * @Route("/diffusion-message", name="diffusion_message")
     */
    public function messageDiffusion(Request $request){
        $users = $this->userRepository->findBy(['role'=>1]);
        $message = $request->request->get('message');
        foreach ($users as $key => $user) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://eu81.chat-api.com/instance121441/sendMessage?token=8tulq0p3h0bhuw31');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "phone=237656645659&body=hallo");

            $headers = array();
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
        }
        return $this->redirectToRoute('list_abonne');
    }
}

