<?php

namespace App\Controller;

use App\Entity\Club;
use App\Entity\Palmares;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TeamController extends AbstractController
{


    /**
     * @Route("/", name="club")
     */
    public function home(): Response
    {
        $dataplayers = $this->getDoctrine()->getRepository(User::class)->findAll();
        $dataclub = $this->getDoctrine()->getRepository(club::class)->findAll();
        $clubtitles = $this->getDoctrine()->getRepository(Palmares::class)->findAll();


        return $this->render('team/index.html.twig', [
            'dataclub' => $dataclub,
            'dataplayers' => $dataplayers,
            'clubtitles' => $clubtitles
        ]);
    }



    /**
     * @Route("/team", name="team")
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // returns your User object, or null if the user is not authenticated
        // use inline documentation to tell your editor your exact User class
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        if ($user->getPosition() == 'goalkeeper') {
            $b = $user->getMatchsjoues();
            $gc = $user->getGoalsConceded();
            if ($b == 0) {
                $user->setPerformance('bad player');
                return $this->render('team/profilegoalkeeper.html.twig', [
                    'age' => $user->getAge(),
                    'photo' => $user->getPhoto(),
                    'fname' => $user->getFirstname(),
                    'lname' => $user->getLastname(),
                    'csd' => $user->getContractSigningDate(),
                    'ced' => $user->getContractEndDate(),
                    'goalsc' => $user->getGoalsConceded(),
                    'position' => $user->getPosition(),
                    'nationality' => $user->getNationality(),
                    'matchsjoues' => $user->getMatchsjoues(),
                    'height' => $user->getHeight(),
                    'performance' => $user->getPerformance(),
                    'b' => $b,
                ]);
            } else {
                $divgc = $gc / $b;

                return $this->render('team/profilegoalkeeper.html.twig', [
                    'age' => $user->getAge(),
                    'photo' => $user->getPhoto(),
                    'fname' => $user->getFirstname(),
                    'lname' => $user->getLastname(),
                    'csd' => $user->getContractSigningDate(),
                    'ced' => $user->getContractEndDate(),
                    'goalsc' => $user->getGoalsConceded(),
                    'position' => $user->getPosition(),
                    'nationality' => $user->getNationality(),
                    'matchsjoues' => $user->getMatchsjoues(),
                    'height' => $user->getHeight(),
                    'performance' => $user->getPerformance(),
                    'b' => $b,
                    'divisiongc' => $divgc,
                ]);
            }
        } elseif ($user->getFirstname() == 'Juan' && $user->getLastname() == 'Laporta') {
            return $this->render('team/profileadmin.html.twig', [
                'age' => $user->getAge(),
                'photo' => $user->getPhoto(),
                'fname' => $user->getFirstname(),
                'lname' => $user->getLastname(),
                'csd' => $user->getContractSigningDate(),
                'ced' => $user->getContractEndDate(),
                'position' => $user->getPosition(),
                'nationality' => $user->getNationality(),
                'username' => $user->getUsername(),

            ]);
        } elseif ($user->getFirstname() == 'pep' && $user->getLastname() == 'guardiola') {
            return $this->render('team/profilemanager.html.twig', [
                'age' => $user->getAge(),
                'photo' => $user->getPhoto(),
                'fname' => $user->getFirstname(),
                'lname' => $user->getLastname(),
                'csd' => $user->getContractSigningDate(),
                'ced' => $user->getContractEndDate(),
                'position' => $user->getPosition(),
                'nationality' => $user->getNationality(),
                'height' => $user->getHeight(),
                'username' => $user->getUsername(),


            ]);
        } else {
            $a = $user->getGoals();
            $b = $user->getMatchsjoues();
            $gc = $user->getGoalsConceded();

            if ($b == 0) {
                $user->setPerformance('bad player');
            } else {
                $div = $a / $b;
                $divgc = $gc / $b;
            }
            return $this->render('team/profile.html.twig', [
                'age' => $user->getAge(),
                'photo' => $user->getPhoto(),
                'fname' => $user->getFirstname(),
                'lname' => $user->getLastname(),
                'csd' => $user->getContractSigningDate(),
                'ced' => $user->getContractEndDate(),
                'goals' => $user->getGoals(),
                'position' => $user->getPosition(),
                'nationality' => $user->getNationality(),
                'matchsjoues' => $user->getMatchsjoues(),
                'height' => $user->getHeight(),
                'performance' => $user->getPerformance(),
                'division' => $div,
                'a' => $a,
                'b' => $b,
                'divisiongc' => $divgc,



            ]);
        }

        // Call whatever methods you've added to your User class
        // For example, if you added a getFirstName() method, you can use that.

    }

    /**
     * @Route("/profile", name="profile")
     */
    public function profile(): Response
    {

        $user = new User();

        return $this->render('team/profile.html.twig', [
            'user_age' => $user->getAge(),
        ]);
    }
}
