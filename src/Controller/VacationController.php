<?php

namespace App\Controller;

use App\Entity\Vacation;
use App\Form\VacationType;
use App\Repository\VacationRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_USER", message="Vous n'avez pas les droits necessaires pour accéder à cette page")
 * @Route("/vacation")
 */
class VacationController extends AbstractController
{
    /**
     * @Route("/", name="vacation_index", methods={"GET"})
     */
    public function index(VacationRepository $vacationRepository): Response
    {
        return $this->render('vacation/index.html.twig', [
            'vacations' => $vacationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="vacation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $vacation = new Vacation();
        $form = $this->createForm(VacationType::class, $vacation);
        try {
            $form->handleRequest($request);
        } catch (Exception $ex) {
            return $this->render('vacation/new.html.twig', [
                'error' => $ex->getMessage(),
                'vacation' => $vacation,
                'form' => $form->createView(),
            ]);
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vacation);
            $entityManager->flush();

            return $this->redirectToRoute('vacation_index');
        }

        return $this->render('vacation/new.html.twig', [
            'error' => null,
            'vacation' => $vacation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vacation_show", methods={"GET"})
     */
    public function show(Vacation $vacation): Response
    {
        return $this->render('vacation/show.html.twig', [
            'vacation' => $vacation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="vacation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Vacation $vacation): Response
    {
        $form = $this->createForm(VacationType::class, $vacation);
        try {
            $form->handleRequest($request);
        } catch (Exception $ex) {
            return $this->render('vacation/new.html.twig', [
                'error' => $ex->getMessage(),
                'vacation' => $vacation,
                'form' => $form->createView(),
            ]);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vacation_index');
        }

        return $this->render('vacation/edit.html.twig', [
            'error' => null,
            'vacation' => $vacation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vacation_delete", methods={"POST"})
     */
    public function delete(Request $request, Vacation $vacation): Response
    {
        if ($this->isCsrfTokenValid('delete' . $vacation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($vacation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('vacation_index');
    }
}
