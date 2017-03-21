<?php

namespace DL\FamilytreeBundle\Controller;

use DL\FamilytreeBundle\Form\Type\PeopleFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DL\FamilytreeBundle\Entity\People;
use Symfony\Component\HttpFoundation\Request;


class PeopleController extends Controller
{
    /**
     * @Route("/people/create", name="people-create")
     */
    public function createAction(Request $request)
    {
        $people = new People();
        $people->setImage(false);
        $form = $this->createForm(PeopleFormType::class, $people);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($people);
            $em->flush();
            return $this->redirectToRoute('people-list');
        }
        return $this->render('DLFamilytreeBundle:People:create.html.twig', [
            'form_data' => $form->createView()
        ]);
    }

    /**
     * @Route("/people/delete/{id}", name="people-delete")
     */
    public function deleteAction($id)
    {
        return $this->render('DLFamilytreeBundle:People:delete.html.twig', [
            'id' => $id
        ]);
    }

    /**
     * @Route("/people/update/{id}", name="people-update")
     */
    public function updateAction($id)
    {
        return $this->render('DLFamilytreeBundle:People:update.html.twig', [
            'id' => $id
        ]);
    }

    /**
     * @Route("/peoples", name="people-list")
     */
    public function listAction()
    {
        return $this->render('DLFamilytreeBundle:People:list.html.twig');
    }
}