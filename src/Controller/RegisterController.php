<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(EntityManagerInterface $manager, Request $request, UserPasswordEncoderInterface $passwordHash): Response
    {
        $form = $this->createForm(UserRegistrationFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            /** @var User $user */
            $user = $form->getData();
            $user->setCreatedAt(new \DateTimeImmutable());
            $user->setPassword($passwordHash->encodePassword(
                $user,
                //Security::doubleHash(
                    $form['rawPassword']->getData()
                //)
            ));

            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'Guess What!!! You Registered '.$user->getFirstname().' 😃');
            return $this->redirectToRoute('app_register');
        }

        return $this->render('register/registration.html.twig', [
            'registerForm' => $form->createView(),
        ]);

    }
}
