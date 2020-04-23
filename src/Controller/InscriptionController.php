<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class InscriptionController extends AbstractController
{ 
	public function inscription(Request $request)
    {	
		return $this->render('website/inscription.html.twig', []);
	}
	public function saveInfoPersoXhr(Request $request)
    {
		return new Response(json_encode(['ok'=> true]), 200);
	}
	public function saveAproposVousXhr(Request $request)
    {
		return new Response(json_encode(['ok'=> true]), 200);
	}
	public function configurationCompteXhr(Request $request)
    {
		return new Response(json_encode(['ok'=> true]), 200);
	}
	public function confirmationIdentiteXhr(Request $request)
    {
		return new Response(json_encode(['ok'=> true]), 200);
	}
}
