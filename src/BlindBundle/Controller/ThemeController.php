<?php

namespace BlindBundle\Controller;

use BlindBundle\Entity\Theme;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
        $repository = $em->getRepository("BlindBundle:Tournoi"); // repository permet de faire les requête find et tout

        $themes = $repository->findAll(); // renvois tout
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
        $theme = new Theme();
        $form = $this->createForm('BlindBundle\Form\ThemeType', $theme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($theme);
            $em->flush();

            return $this->redirectToRoute('theme_show', array('id' => $theme->getId()));
        }

        return $this->render('theme/new.html.twig', array(
                    'theme' => $theme,
                    'form' => $form->createView(),
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
