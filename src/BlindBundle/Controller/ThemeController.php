<?php

namespace BlindBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use BlindBundle\Entity\Theme;
use BlindBundle\Form\ThemeType;

/**
 * Theme controller.
 *
 */
class ThemeController extends Controller {

    /**
     * Lists all theme entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager(); // Création de l'outil d'accès à la BDD
        $repository = $em->getRepository("BlindBundle:Theme"); // repository permet de faire les requête find et tout

        $lesThemes = $repository->findAll(); // renvois tout
        
        // On renvois la page avec la variable contenant l'objet
        return $this->render('@Blind/Theme/index.html.twig', array(
                    'lesThemes' => $lesThemes,
        ));
    }

    /**
     * Creates a new theme entity.
     *
     */
    public function newAction(Request $request) {
        // 1) build the form
        $theme = new Theme();
        $form = $this->createForm(ThemeType::class, $theme);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            // 3) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($theme);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('theme_index');
        }

        return $this->render('@Blind/Theme/create.html.twig', array(
                    'theme' => $theme,
                    'form' => $form->createView()
        ));
    }

    /**
     * Finds and displays a theme entity.
     *
     */
    public function showAction(Theme $theme) {
        $deleteForm = $this->createDeleteForm($theme);

        return $this->render('theme/show.html.twig', array(
                    'theme' => $theme,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing theme entity.
     *
     */
    public function editAction(Request $request, Theme $theme) {
        $deleteForm = $this->createDeleteForm($theme);
        $editForm = $this->createForm('BlindBundle\Form\ThemeType', $theme);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('theme_edit', array('id' => $theme->getId()));
        }

        return $this->render('theme/edit.html.twig', array(
                    'theme' => $theme,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a theme entity.
     *
     */
    public function deleteAction(Request $request, Theme $theme) {
        $form = $this->createDeleteForm($theme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($theme);
            $em->flush();
        }

        return $this->redirectToRoute('theme_index');
    }

    /**
     * Creates a form to delete a theme entity.
     *
     * @param Theme $theme The theme entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Theme $theme) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('theme_delete', array('id' => $theme->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
