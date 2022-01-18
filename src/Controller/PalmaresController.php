<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Palmares;
use App\Form\PalmaresType;
use App\Repository\PalmaresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/palmares")
 */
class PalmaresController extends AbstractController
{
    /**
     * @Route("/", name="palmares_index", methods={"GET"})
     */
    public function index(PalmaresRepository $palmaresRepository): Response
    {
        /** @var \App\Entity\User $user_auth */
        $user_auth = $this->getUser();
        if ($user_auth->getEmail() == 'laporta@admin.com') {
            return $this->render('palmares/index.html.twig', [
                'palmares' => $palmaresRepository->findAll(),
            ]);
        } else {
            return $this->render('user/error.html.twig');
        }
    }

    /**
     * @Route("/new", name="palmares_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $palmare = new Palmares();
        $form = $this->createForm(PalmaresType::class, $palmare);
        $form->handleRequest($request);

        /** @var \App\Entity\User $user_auth */
        $user_auth = $this->getUser();
        if ($user_auth->getEmail() == 'laporta@admin.com') {

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($palmare);
                $entityManager->flush();
                $this->addFlash('notice', 'title added succefully !');

                return $this->redirectToRoute('palmares_new', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('palmares/new.html.twig', [
                'palmare' => $palmare,
                'form' => $form,
            ]);
        } else {
            return $this->render('user/error.html.twig');
        }
    }

    /**
     * @Route("/{id}", name="palmares_show", methods={"GET"})
     */
    public function show(Palmares $palmare): Response
    {
        /** @var \App\Entity\User $user_auth */
        $user_auth = $this->getUser();
        if ($user_auth->getEmail() == 'laporta@admin.com') {
            return $this->render('palmares/show.html.twig', [
                'palmare' => $palmare,
            ]);
        } else {
            return $this->render('user/error.html.twig');
        }
    }

    /**
     * @Route("/{id}/edit", name="palmares_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Palmares $palmare, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PalmaresType::class, $palmare);
        $form->handleRequest($request);
        /** @var \App\Entity\User $user_auth */
        $user_auth = $this->getUser();
        if ($user_auth->getEmail() == 'laporta@admin.com') {

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();

                return $this->redirectToRoute('palmares_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('palmares/edit.html.twig', [
                'palmare' => $palmare,
                'form' => $form,
            ]);
        } else {
            return $this->render('user/error.html.twig');
        }
    }

    /**
     * @Route("/{id}", name="palmares_delete", methods={"POST"})
     */
    public function delete(Request $request, Palmares $palmare, EntityManagerInterface $entityManager): Response
    {
        /** @var \App\Entity\User $user_auth */
        $user_auth = $this->getUser();
        if ($user_auth->getEmail() == 'laporta@admin.com') {

            if ($this->isCsrfTokenValid('delete' . $palmare->getId(), $request->request->get('_token'))) {
                $entityManager->remove($palmare);
                $entityManager->flush();
            }

            return $this->redirectToRoute('palmares_index', [], Response::HTTP_SEE_OTHER);
        } else {
            return $this->render('user/error.html.twig');
        }
    }
}
