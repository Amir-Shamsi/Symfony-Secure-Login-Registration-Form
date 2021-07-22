<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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
            $data = $form->getData();
            dd(['firstName']);
            $user = new User();
            $user->setFirstName($data['firstName']);
            $user->setLastName($data['lastName']);
            $user->setUsername($data['username']);
            $user->setEmail($data['email']);
            $user->setCreatedAt(new \DateTimeImmutable());
            $user->setPassword($passwordHash->hashPassword(
                $user,
                //Security::doubleHash(
                    $request->request->get('password')
                //)
            ));

            $manager->persist($user);
            $manager->flush();

        $this->addFlash('success', 'Guess What!!! You Registered 😃');
        }

        return $this->render('register/registration.html.twig', [
            'registerForm' => $form->createView(),
        ]);

    }
}
