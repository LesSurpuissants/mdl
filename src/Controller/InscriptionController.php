<?php

namespace App\Controller;

use App\Entity\Atelier;
use App\Entity\Inscription;
use App\Entity\Licencie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\User;

/**
 * @IsGranted("ROLE_INSCRIT", message="Vous n'avez pas les droits necessaires pour accéder à cette page")
 * @Route("/inscription", name="inscription")
 */
class InscriptionController extends AbstractController
{
    /**
     * @Route("/", name="_index")
     */
    public function index(): Response
    {
        $ateliers = $this->getDoctrine()->getRepository(Atelier::class)->findAll();

        return $this->render('inscription/index.html.twig', [
            'ateliers' => $ateliers,
            'controller_name' => 'InscriptionController',
        ]);
    }

    /**
     * @Route("/changer_email", name="_changeEmail", methods={"POST"})
     * 
     *
     * @param Request $request
     * @param UserInterface $user
     * @return Response
     */
    public function changeEmail(Request $request): Response
    {
        if ($request->get('email')) {
            $user = $this->getUser();
            $user->setEmail($request->get('email'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Email modifié avec succès.');
        } else {
            $this->addFlash('error', 'Un problème est survenu.');
        }

        return $this->redirectToRoute('inscription_index');
    }

    /**
     * @Route("/submit", name="_submit", methods={"POST"})
     * 
     *
     * @param Request $request
     * @return Response
     */
    public function inscription(Request $request): Response
    {
        if (!$user = $this->getUser()) {
            return $this->redirectToRoute('home');
        }
        $inscription = new Inscription();
        $inscription->setCompte($user);
        //Gestion des ateliers
        $countAtelier = 0;
        for ($i = 1; $i < 7; $i++) {
            if ($request->get('atelier' . $i)) {
                $atelier = $this->getDoctrine()->getRepository(Atelier::class)->find($i);
                if (!$atelier->hasPlaceDisponible()) {
                    $this->addFlash('errorAtelier', 'Aucune place disponible pour l\'atelier' . $atelier->getLibelle() . '.');

                    return $this->redirectToRoute('inscription_index');
                }
                $countAtelier++;
                $inscription->addAtelier($atelier);
            } else {
                $this->addFlash('errorAtelier', 'Une erreur est survenu.');

                return $this->redirectToRoute('inscription_index');
            }
        }
        //Gestion du "5 ateliers maximum"
        if ($countAtelier > 5) {
            $this->addFlash('errorAtelier', 'Vous ne pouvez sélectionner plus de 5 ateliers.');

            return $this->redirectToRoute('inscription_index');
        }
        dd($inscription);
        return $this->redirectToRoute('inscription_index');
    }
}
