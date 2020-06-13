<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\component\HttpFoundation\File\UploadedFile;
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
    private $mailer;
    private $msgLink = "https://eu140.chat-api.com/instance137096/";
    private $key = "9girba15379ax0ys";
    
	public function __construct(Security $security, InformationRepository $informationRepository, UserRepository $userRepository, ParameterBagInterface $params, \Swift_Mailer $mailer)
    {
        $this->security = $security;
        $this->userRepository = $userRepository;
        $this->informationRepository = $informationRepository;
        $this->params = $params;
        $this->mailer = $mailer;
    }	

    /**
     * @Route("/dashboard/abonne-action/{user_id}/{abonne}", name="abonne_action")
     */
    public function abonnePass(Request $request, $user_id, $abonne)
    {   
        $em = $this->getDoctrine()->getManager();
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->security->getUser();
        if($user->getRole() == 1)
            return $this->redirectToRoute('inscription_home');
        
        $user = $this->userRepository->find($user_id);
        if($abonne == "abonne"){
            $user->setAbonne(1);
            $this->addFlash("success", "Utilisateur désabonné");
            $response = $this->redirectToRoute('list_abonne', ['abonne'=>'desabonne']);
        }
        elseif($abonne == "desabonne"){
            $user->setAbonne(0);
            $this->addFlash("success", "Utilisateur désabonné");
            $response = $this->redirectToRoute('list_abonne', ['abonne'=>'abonne']);
        }
        $em->flush();
        return $response;
    }

	public function infosAbonne(Request $request, $id)
    {
    	$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
    	$user = $this->security->getUser();
    	if($user->getRole() == 1)
    		return $this->redirectToRoute('inscription_home');
		
    	$informations = $this->informationRepository->findOneBy(['user'=>$id]);
        if(is_null($informations)){
            $this->addFlash("infos", "Cet utilisateur n'a pas encore renseigné ces informations");
            return $this->redirectToRoute('list_abonne');
        }
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
        $user = $this->security->getUser();
        if($user->getRole() == 1)
            return $this->redirectToRoute('inscription_home');

        $users = $this->userRepository->findBy(['abonne'=>1]);
        $message = $request->request->get('message') ?? "";
        $sujet = $request->request->get('sujet') ?? "";
        //$url = $request->request->get('url') ?? "";
        $fichier = $request->files->get('fichier') ?? "";
        $tabMail = [];
        if($message =="" && !($request->files->get('fichier') instanceof UploadedFile))
            return new Response('Remplir au moins un champ', 500);
        
        foreach ($users as $key => $user) {
            $tabMail[] = $user->getEmail();
            if($message !=""){
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://eu140.chat-api.com/instance137096/sendMessage?token=9girba15379ax0ys');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "phone=".$user->getTelephone()."&body=".$message."");

                $headers = array();
                $headers[] = 'Content-Type: application/x-www-form-urlencoded';
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $result = curl_exec($ch);
                if (curl_errno($ch)) {
                    echo 'Error:' . curl_error($ch);
                }
                curl_close($ch);
            }
            /*if($url !=""){
            }*/
            if($request->files->get('fichier') instanceof UploadedFile){
                $file = $request->files->get('fichier');
                $file_tmp = $file->getRealPath();
                $type = pathinfo($file_tmp, PATHINFO_EXTENSION);
                $data = file_get_contents($file_tmp);
                $base64 = 'data:'.$file->getMimeType().';base64,' . base64_encode($data);
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://eu140.chat-api.com/instance137096/sendMessage?token=9girba15379ax0ys');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "phone=".$user->getTelephone()."&body=".$base64."&filename=".$file->getClientOriginalName());

                $headers = array();
                $headers[] = 'Content-Type: application/x-www-form-urlencoded';
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $result = curl_exec($ch);
                if (curl_errno($ch)) {
                    echo 'Error:' . curl_error($ch);
                }
                curl_close($ch);
            }
        }

        try {
            $mail = (new \Swift_Message($sujet))
                ->setFrom(array('alexngoumo.an@gmail.com' => 'Epo trading'))
                ->setTo($tabMail)
                ->setCc("alexngoumo.an@gmail.com")
                //->attach(Swift_Attachment::fromPath('my-document.pdf'))
                ->setBody( $message, 'text/html'
                );
            $this->mailer->send($mail);
            
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
        //return new Response("Enregistrement effectuer avec succèes") ;
        return $this->redirectToRoute('list_abonne');
    }


    /**
     * @Route("/dashboard/list-abonne/{abonne}", name="list_abonne")
     */
    public function listAbonne(Request $request, $abonne = 'abonne')
    {   
        $abonne_find = ($abonne == 'abonne') ? 1:0;
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->security->getUser();
        if($user->getRole() == 1)
            return $this->redirectToRoute('inscription_home');
        
        $users = $this->userRepository->findBy(['abonne'=>$abonne_find]);
        return $this->render('backoffice/abonne_list.html.twig', [
            'users'=>$users,
            'abonne'=>$abonne
        ]);
    }
}

    /*
        public function messageDiffusion(Request $request){
        $users = $this->userRepository->findBy(['role'=>1]);
        $message = $request->request->get('message');
        $tabMail = [];
        foreach ($users as $key => $user) {
            $tabMail[] = $user->getEmail();
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://eu81.chat-api.com/instance121441/sendMessage?token=8tulq0p3h0bhuw31');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "phone=".$user->getTelephone()."&body=".$message."");

            $headers = array();
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
        }

        try {
            $mail = (new \Swift_Message('Message de Epotrade'))
                ->setFrom(array('alexngoumo.an@gmail.com' => 'Epo trading'))
                ->setTo($tabMail)
                ->setCc("alexngoumo.an@gmail.com")
                ->setBody( $message, 'text/html'
                );
            $this->mailer->send($mail);
            
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    */