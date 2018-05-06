<?php

namespace BlindBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use BlindBundle\Entity\Tournoi;
use BlindBundle\Form\TournoiType;

class TournoiController extends Controller {

    public function indexAction() {
        $em = $this->getDoctrine()->getManager(); // Création de l'outil d'accès à la BDD
        $repository = $em->getRepository("BlindBundle:Tournoi"); // repository permet de faire les requête find et tout

        $lesTournois = $repository->findAll(); // renvois tout

        /*
          $unTournoi = new Tournoi();
          $unTournoi->setName('Keyboard');
          $unTournoi->setPrice(1991-11-05);
         */

        // On renvois la page avec la variable contenant l'objet
        return $this->render('@Blind/Tournoi/index.html.twig', array(
                    'lesTournois' => $lesTournois,
        ));
    }

    public function newAction(Request $request) {

        // 1) build the form
        $tournoi = new Tournoi();
        $form = $this->createForm(TournoiType::class, $tournoi);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            // 3) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($tournoi);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('tournoi_index');
        }

        return $this->render('@Blind/Tournoi/create.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    /**
     * Deletes a tournoi entity.
     *
     */
    public function deleteAction(Request $request, Tournoi $tournoi) {
        $form = $this->createDeleteForm($tournoi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tournoi);
            $em->flush();
        }

        return $this->redirectToRoute('tournoi_index');
    }

}
