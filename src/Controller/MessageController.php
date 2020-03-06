<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Form\MessagesType;
use App\Repository\MessagesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    /**
     * @Route("/message", methods={"GET"}, name="message_index")
     */
    public function index(MessagesRepository $messagesRepository)
    {
        return $this->render('message/index.html.twig', [
            'title' => 'Mes messages',
            'messages' => $messagesRepository->findAll(),
        ]);
    }
    
    
    /**
     * @Route("/message/new", name="message_new", methods={"GET","POST"})
     */
    public function new(Request $request)
    {
        $message = new Messages();
        $message->setDate(new \DateTime());
        $form = $this->createForm(MessagesType::class, $message);
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->flush();
            
            return $this->redirectToRoute('message_index');
        }

        return $this->render('message/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/message/{id}", name="message_show", methods={"GET"})
     */
    public function show(Messages $message)
    {
        return $this->render('message/show.html.twig', [
            'message' => $message,
        ]);
    }
    
    
    
    
}
