<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        /** @var \App\Entity\User $user_auth */
        $user_auth = $this->getUser();
        if ($user_auth->getEmail() == 'laporta@admin.com') {
            return $this->render('user/index.html.twig', [
                'users' => $userRepository->findAll(),
            ]);
        }
        if ($user_auth->getEmail() == 'pep@guardiola.com') {
            return $this->render('user/showplayers.html.twig', [
                'users' => $userRepository->findAll(),
            ]);
        } else {
            return $this->render('user/error.html.twig');
        }
    }

    /**
     * @Route("/new", name="user_new", methods={"GET", "POST"})
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        /** @var \App\Entity\User $user_auth */
        $user_auth = $this->getUser();
        if ($user_auth->getEmail() == 'laporta@admin.com') {
            if ($form->isSubmitted() && $form->isValid()) {
                // encode the plain password
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );

                $entityManager->persist($user);
                $entityManager->flush();
                // do anything else you need here, like send an email

                $this->addFlash('notice', 'player added succefully !');
            }

            return $this->render('registration/register.html.twig', [
                'registrationForm' => $form->createView(),
            ]);
        } else {
            return $this->render(
                'user/error.html.twig'
            );
        }
    }

    /**
     * @Route("/{username}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        /** @var \App\Entity\User $user_auth */
        $user_auth = $this->getUser();
        $a = $user->getGoals();
        $b = $user->getMatchsjoues();
        $gc = $user->getGoalsConceded();
        if ($user_auth->getEmail() == 'laporta@admin.com') {
            if ($b == 0) {
                $user->setPerformance('bad player');
                return $this->render('user/show.html.twig', [
                    'user' => $user,
                    'a' => $a,
                    'b' => $b,

                ]);
            } else {
                $div = $a / $b;
                if ($user->getPosition() == 'goalkeeper' || $user->getPosition() == 'center back' || $user->getPosition() == 'center midfielder') {
                    $divgc = $gc / $b;

                    return $this->render('user/show.html.twig', [
                        'user' => $user,
                        'division' => $div,
                        'divisiongc' => $divgc,
                        'a' => $a,
                        'b' => $b

                    ]);
                } else {
                    return $this->render('user/show.html.twig', [
                        'user' => $user,
                        'division' => $div,
                        'a' => $a,
                        'b' => $b

                    ]);
                }
            }
        }
        if ($user_auth->getEmail() == 'pep@guardiola.com') {
            if ($b == 0) {
                $user->setPerformance('bad player');
                return $this->render('user/showplayer.html.twig', [
                    'user' => $user,
                    'a' => $a,
                    'b' => $b

                ]);
            } else {
                $div = $a / $b;

                if ($user->getPosition() == 'goalkeeper' || $user->getPosition() == 'center back' || $user->getPosition() == 'center midfielder') {
                    $divgc = $gc / $b;

                    return $this->render('user/showplayer.html.twig', [
                        'user' => $user,
                        'division' => $div,
                        'divisiongc' => $divgc,
                        'a' => $a,
                        'b' => $b

                    ]);
                } else {
                    return $this->render('user/showplayer.html.twig', [
                        'user' => $user,
                        'division' => $div,
                        'a' => $a,
                        'b' => $b

                    ]);
                }
            }
        } else {
            return $this->render(
                'user/error.html.twig'
            );
        }
    }

    /**
     * @Route("/{username}/edit", name="user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        /** @var \App\Entity\User $user_auth */
        $user_auth = $this->getUser();
        if ($user_auth->getEmail() == 'laporta@admin.com') {
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();

                return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('user/edit.html.twig', [
                'user' => $user,
                'form' => $form,
            ]);
        } else {
            return $this->render(
                'user/error.html.twig'
            );
        }
    }


    /**
     * @Route("/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        /** @var \App\Entity\User $user_auth */
        $user_auth = $this->getUser();
        if ($user_auth->getEmail() == 'laporta@admin.com') {
            if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
                $entityManager->remove($user);
                $entityManager->flush();
            }

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        } else {
            return $this->render(
                'user/error.html.twig'
            );
        }
    }
}
