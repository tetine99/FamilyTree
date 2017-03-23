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

class PeopleController extends Controller{

	/**
	*@Route("/people", name="people")
	*/
	public function indexAction(Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$peoples = $em->getRepository('DLFamilytreeBundle:People')
			->findAll();

		return $this->render('DLFamilytreeBundle:People:index.html.twig', [
			'peoples'=>$peoples
		]);
	}


	/**
	*@Route("/people/add", name="people_add")
	*@Method({"GET", "POST"})
	*/
	public function addAction(Request $request)
	{
		$people = new People();

		$form = $this->createForm(PeopleFormType::class, $people);

		$form->handleRequest($request);
			if($form->isSubmitted() && $form->isValid()){

				// $file = $people->getImage();

				// if (!is_Null($file)){
				//   // Generate a unique name for the file before saving it
				//   $fileName = md5(uniqid()).'.'.$file->guessExtension();
				//   // Move the file to the directory where brochures are stored
				//   $file->move(
				//      $this->getParameter('img_directory'),
				//      $fileName
				//   );
				//   // Update the 'brochure' property to store the PDF file name
				//   // instead of its contents
				//   $people->setImage($fileName);
				//  }

				$em = $this->getDoctrine()->getManager();
				$em->persist($people);  //constitue l'objet
				$em->flush();         //enregistre en bdd

				return $this->redirectToRoute('people');
			}
		return $this->render('DLFamilytreeBundle:People:add.html.twig',[
			'form'=>$form->createView()
		]);
	}


	/**
	 * @Route("/people/update/{id}", name="people_update", defaults={"id"=null})
	 * @Method({"GET", "POST"})
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
		 return $this->render('DLFamilytreeBundle:people:update.html.twig', [
				 'form' => $form->createView()
		 ]);
	 }

	 /**
		* @Route("/people/delete/{id}", name="people_delete", defaults={"id"=null})
		*/
	 public function deleteAction(Request $request)
	 {
		 $id = $request->get('id');
		 $em = $this->getDoctrine()->getManager();
		 $people = $em->getRepository('DLFamilytreeBundle:People')->find($id);

		 $em->remove($people);
		 $em->flush();
		 return $this->redirectToRoute('people');
	 }



}
