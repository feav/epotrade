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
}
