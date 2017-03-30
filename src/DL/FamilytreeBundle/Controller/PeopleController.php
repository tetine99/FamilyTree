<?php

namespace DL\FamilytreeBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use DL\FamilytreeBundle\Form\Type\PeopleFormType;
use DL\FamilytreeBundle\Entity\People;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class PeopleController extends Controller{

	/**
	*@Route("/people", name="people")
	*@Method({"GET", "POST"})
	* @Security("has_role('ROLE_USER')")
	*/
	public function indexAction(Request $request)
	{
		//affiche la liste des personnes
		$em = $this->getDoctrine()->getManager();
		$peoples = $em->getRepository('DLFamilytreeBundle:People')
			->findAll();

		//ajoute une personne
		$people = new People();
		$form = $this->createForm(PeopleFormType::class, $people);
		$form->handleRequest($request);
			if($form->isSubmitted() && $form->isValid()){
				$em = $this->getDoctrine()->getManager();
				$em->persist($people);  //constitue l'objet
				$em->flush();         //enregistre en bdd
				return $this->redirectToRoute('people');
			}

		return $this->render('DLFamilytreeBundle:People:index.html.twig', [
			'peoples'=>$peoples,
			'form'=>$form->createView()
		]);
	}


	/**
	 * @Route("/people/update/{id}", name="people_update", defaults={"id"=null})
	 * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
	 */
    public function updateAction(Request $request)
    {
        $id = $request->get('id');

        $em = $this->getDoctrine()->getManager();
        $people = $em->getRepository('DLFamilytreeBundle:People')->find($id);

        $form = $this->createForm(PeopleFormType::class, $people);

        $form->handleRequest($request);
        if($form->isValid()) {
            $data = $form->getData();

            $file = $people->getImageFile();
            $em->flush();

            return $this->redirectToRoute('people');

        }
        return $this->render('DLFamilytreeBundle:People:update.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
    * @Route("/people/delete/{id}", name="people_delete", defaults={"id"=null})
    * @Security("has_role('ROLE_USER')")
    *
    */
    public function deleteAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $people = $em->getRepository('DLFamilytreeBundle:People')->find($id);
        if ($people!=null){
            $relations = $em->getRepository('DLFamilytreeBundle:Relation')->findAll();
            foreach ($relations as $rel){
                if ($rel->getPeopleA()->getId()==$people->getId()
                    || $rel->getPeopleB()->getId()==$people->getId()){
                    $em->remove($rel);
                }
            }
            $em->remove($people);
            $em->flush();
        }
        return $this->redirectToRoute('people');
    }



}
