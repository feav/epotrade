<?php

namespace App\Controller;

use App\Entity\Signaux;
use App\Form\SignauxType;
use App\Repository\SignauxRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard/signaux")
 */
class SignauxController extends AbstractController
{
    /**
     * @Route("/", name="signaux_index", methods={"GET"})
     */
    public function index(SignauxRepository $signauxRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        if($user->getRole() == 1)
            return $this->redirectToRoute('inscription_home');

        return $this->render('signaux/index.html.twig', [
            'signauxes' => $signauxRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="signaux_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $signaux = new Signaux();
        $form = $this->createForm(SignauxType::class, $signaux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($signaux);
            $entityManager->flush();

            return $this->redirectToRoute('signaux_index');
        }

        return $this->render('signaux/new.html.twig', [
            'signaux' => $signaux,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="signaux_show", methods={"GET"})
     */
    public function show(Signaux $signaux): Response
    {
        return $this->render('signaux/show.html.twig', [
            'signaux' => $signaux,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="signaux_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Signaux $signaux): Response
    {
        $form = $this->createForm(SignauxType::class, $signaux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('signaux_index');
        }

        return $this->render('signaux/edit.html.twig', [
            'signaux' => $signaux,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="signaux_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Signaux $signaux): Response
    {
        if ($this->isCsrfTokenValid('delete'.$signaux->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($signaux);
            $entityManager->flush();
        }

        return $this->redirectToRoute('signaux_index');
    }
}
