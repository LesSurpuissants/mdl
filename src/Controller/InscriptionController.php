<?php

namespace App\Controller;

use App\Entity\Atelier;
use App\Entity\Hotel;
use App\Entity\Inscription;
use App\Entity\Licencie;
use App\Entity\Nuite;
use App\Entity\Restauration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManager;

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
        $hotels = $this->getDoctrine()->getRepository(Hotel::class)->findAll();

        return $this->render('inscription/index.html.twig', [
            'hotels' => $hotels,
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
     * Ajoute les ateliers sélectionnés à l'inscription dans le request et retourne l'inscription (vérifie la règle de <5)
     *
     * @param Request $request
     * @param Inscription $inscription
     * @return Inscription
     */
    private function addAteliers(Request $request, Inscription $inscription): Inscription
    {
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
            }
        }
        //Gestion du "5 ateliers maximum"
        if ($countAtelier > 5) {
            $this->addFlash('errorAtelier', 'Vous ne pouvez sélectionner plus de 5 ateliers.');

            return $this->redirectToRoute('inscription_index');
        }

        return $inscription;
    }

    /**
     * Ajoute les restaurations sélectionnés dans les request, + modifie le montant total de l'inscription, retourne l'inscription
     *
     * @param Request $request
     * @param Inscription $inscription
     * @param EntityManager $entityManager
     * @return Inscription
     */
    private function addRestaurations(Request $request, Inscription $inscription, EntityManager $entityManager): Inscription
    {
        //Gestion des repas

        if ($request->get('dejSam')) {
            $restauration = new Restauration();
            $restauration->setDateRestauration(new DateTime('2021-09-14'));
            $restauration->setTypeRepas("déjeuner");
            $inscription->addRestauration($restauration);
            $entityManager->persist($restauration);
            $inscription->setMontant($inscription->getMontant() + 35);
        }
        if ($request->get('dinSam')) {
            $restauration = new Restauration();
            $restauration->setDateRestauration(new DateTime('2021-09-14'));
            $restauration->setTypeRepas("dîner");
            $inscription->addRestauration($restauration);
            $entityManager->persist($restauration);
            $inscription->setMontant($inscription->getMontant() + 35);
        }
        if ($request->get('dejDim')) {
            $restauration = new Restauration();
            $restauration->setDateRestauration(new DateTime('2021-09-15'));
            $restauration->setTypeRepas("déjeuner");
            $inscription->addRestauration($restauration);
            $entityManager->persist($restauration);
            $inscription->setMontant($inscription->getMontant() + 35);
        }

        return $inscription;
    }

    private function addHotels(Request $request, Inscription $inscription): Inscription
    {
        if ($nuit13 = $request->get('nuit13')) {
            if ($nuite = $this->getDoctrine()->getRepository(Nuite::class)->find($nuit13)) {
                $inscription->addNuite($nuite);
                $inscription->setMontant($inscription->getMontant() + $nuite->getProposer()->getTarifNuite());
            } else {
                $this->addFlash('errorNuite', 'Une erreur est survenu.');

                return $this->redirectToRoute('inscription_index');
            }
        }
        if ($nuit14 = $request->get('nuit14')) {
            if ($nuite2 = $this->getDoctrine()->getRepository(Nuite::class)->find($nuit14)) {
                $inscription->addNuite($nuite2);
                $inscription->setMontant($inscription->getMontant() + $nuite2->getProposer()->getTarifNuite());
            } else {
                $this->addFlash('errorNuite', 'Une erreur est survenu.');

                return $this->redirectToRoute('inscription_index');
            }
        }

        return $inscription;
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
        //Au cas où il y aurait un problème avec la récupération du user
        if (!$user = $this->getUser()) {
            return $this->redirectToRoute('home');
        }
        $inscription = new Inscription();
        $inscription->setCompte($user);
        $entityManager = $this->getDoctrine()->getManager();

        //Gestion des ateliers
        $inscription = $this->addAteliers($request, $inscription);

        //Gestion du montant total
        $inscription->setMontant(100);

        //Gestion des hotels
        $inscription = $this->addHotels($request, $inscription);

        //Gestion des repas
        $inscription = $this->addRestaurations($request, $inscription, $entityManager);

        $entityManager->persist($inscription);
        $entityManager->flush();

        return $this->redirectToRoute('inscription_recap');
    }


    /**
     * @Route("/recap", name="_recap")
     *
     * @return Response
     */
    public function recap(): Response
    {
        return $this->render('inscription/recap.html.twig');
    }
}
