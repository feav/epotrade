<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Service\FileUploader;
use App\Repository\InformationRepository;
use App\Entity\Information;

class InscriptionController extends AbstractController
{ 
	private $informationRepository;
	private $params;
	public function __construct(Security $security, InformationRepository $informationRepository, ParameterBagInterface $params)
    {
        $this->security = $security;
        $this->informationRepository = $informationRepository;
        $this->params = $params;
    }
	public function inscription(Request $request)
    {	
    	$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
    	$user = $this->security->getUser();
    	$informations = $this->informationRepository->findOneBy(['user'=>$user->getId()]);
    	$em = $this->getDoctrine()->getManager();
		return $this->render('website/inscription.html.twig', ['informations'=>$informations, 'user'=>$user]);
	}
	public function saveInfoPersoXhr(Request $request)
    {	
    	$em = $this->getDoctrine()->getManager();
    	$user = $this->security->getUser();
    	$information = $user->getInformation();
    	if(is_null($information))
    		$information = new Information;
    	elseif($information->getIsCreate())
    		return new Response('vos informations ont deja été traitées', 500);

    	$information->setUser($user);
    	$information->setPrenom($request->request->get('prenom'));
    	$information->setNomFamille($request->request->get('nom_famille'));
    	$information->setSecondName($request->request->get('second_name'));
    	$information->setNationalite($request->request->get('nationalite'));
    	$information->setEmail($request->request->get('email'));
    	$information->setTelephone($request->request->get('telephone'));

    	$dateNaiss = $request->request->get('annee_naiss').'-'.$request->request->get('mois_naiss').'-'.$request->request->get('jour_naiss');
    	if( ($request->request->get('annee_naiss') > 2002) && ($request->request->get('annee_naiss') < 1987) )
    		return new Response("la date entrée n'est pas dans l'intervale autorisé", 500);
    	$information->setDateNaiss(new \Datetime($dateNaiss));
    	$information->setLieuNaiss($request->request->get('lieu_naiss'));
    	$information->setIdentificationType($request->request->get('ident_type'));
    	$information->setNumeroIdentite($request->request->get('ident_number'));
    	$information->setPaysResidence($request->request->get('pays_residence'));
    	$information->setAdresse($request->request->get('adresse'));
    	$information->setEtat($request->request->get('province'));
    	$information->setVille($request->request->get('ville'));
    	$information->setCodePostale($request->request->get('codepostal'));
    	$information->setIsReferred((int)$request->request->get('referred'));
    	$em->persist($information);
    	$em->flush();

		return new Response(json_encode(['ok'=> true]), 200);
	}
	public function saveAproposVousXhr(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$user = $this->security->getUser();
    	$information = $user->getInformation();
    	if(is_null($information))
    		$information = new Information;
    	elseif($information->getIsCreate())
    		return new Response('vos informations ont deja été traitées', 500);

    	$information->setUser($user);
    	$information->setStatusEmploi($request->request->get('statut_emploi'));
    	$information->setRevenueAnnuel($request->request->get('revenue_annuel'));
    	$information->setEconomieInvestissement($request->request->get('invest_economie'));
    	$information->setDepotEstime($request->request->get('depot'));
    	$information->setSourceFond($request->request->get('source_fond'));
    	$information->setNbTransaction($request->request->get('nbr_transaction'));
    	$information->setQteEchangeSemaine($request->request->get('qte_echange'));

    	$em->persist($information);
    	$em->flush();

		return new Response(json_encode(['ok'=> true]), 200);
	}
	public function configurationCompteXhr(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$user = $this->security->getUser();
    	$information = $user->getInformation();
    	if(is_null($information))
    		$information = new Information;
    	elseif($information->getIsCreate())
    		return new Response('vos informations ont deja été traitées', 500);

    	$information->setUser($user);
    	$information->setTradingPlateforme($request->request->get('trading_plateform'));
    	$information->setTypeCompte($request->request->get('account_type'));
    	$information->setDevise($request->request->get('devise'));
    	$information->setCgu((int)$request->request->get('cgu'));

    	$em->persist($information);
    	$em->flush();
		return new Response(json_encode(['ok'=> true]), 200);
	}
	public function confirmationIdentiteXhr(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$user = $this->security->getUser();
    	$information = $user->getInformation();
    	if(is_null($information))
    		$information = new Information;
    	elseif($information->getIsCreate())
    		return new Response('vos informations ont deja été traitées', 500);

    	$information->setUser($user);
    	$information->setIsComplete(true);
    	if( ($request->files->get('identite') instanceof UploadedFile) && 
            (($request->files->get('identite'))->getError()=="0")){
            $assetFile = "/public/documents/identite/";
            if (!file_exists($this->params->get('kernel.project_dir'). $assetFile)) {
                mkdir($this->params->get('kernel.project_dir') . $assetFile, 0755);
            }
            $fullAssetFile = $this->params->get('kernel.project_dir') . $assetFile;
            $information->setIdentiteDoc($this->buildFiles([$request->files->get('identite')], ['jpg', 'png', 'jpeg'], 100000000, $fullAssetFile, false)[0]);
        }
        if( ($request->files->get('residence') instanceof UploadedFile) && 
            (($request->files->get('residence'))->getError()=="0")){
            $assetFile = "/public/documents/residence/";
            if (!file_exists($this->params->get('kernel.project_dir'). $assetFile)) {
                mkdir($this->params->get('kernel.project_dir') . $assetFile, 0755);
            }
            $fullAssetFile = $this->params->get('kernel.project_dir') . $assetFile;
            $information->setResidenceDoc($this->buildFiles([$request->files->get('residence')], ['jpg', 'png', 'jpeg'], 100000000, $fullAssetFile, false)[0]);
        }

    	$em->persist($information);
    	$em->flush();
		return new Response(json_encode(['ok'=> true]), 200);
	}

    public function buildFiles($files, $tabExtension, $maxSize, $directorySave, $save_originalName){
        $filesArray = array();
        foreach ($files as $key => $value) {
            if( ($value instanceof UploadedFile) && ($value->getError()=="0")){
                if($value->getSize() < $maxSize){
                    $originalName=$value->getClientOriginalName();
                    $name_array = explode('.',$originalName);
                    $file_type=$name_array[sizeof($name_array)-1];
                    $nameWithoutExt = str_replace(".".$file_type, "", $originalName);
                    $valid_filetypes=  $tabExtension;
                    
                    if(in_array(strtolower($file_type),$valid_filetypes)){
                        if($save_originalName)
                            $name = $originalName;
                        else
                            $name=$nameWithoutExt.'-'.Date("Yds").'.'.$file_type;
                        $value->move($directorySave, $name);
                        $filesArray[] = $name;
                    }else{
                    	print_r("Entrez votre image avec une extension valide", 500);
                    }
                }else{
                	print_r("Fichier trop lourd".$value->getSize(), 500);
                }
            }else{
            	print_r("Erreur de chargement du fichier", 500);
            }            
        }
        return $filesArray;
    }
}
