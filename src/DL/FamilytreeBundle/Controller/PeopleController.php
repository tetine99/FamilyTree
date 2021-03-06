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
use DL\FamilytreeBundle\Entity\Tree;
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
		// $peoples = $em->getRepository('DLFamilytreeBundle:People')
		 	//->findAll();

		$peoples = $this->container->get('security.token_storage')
			->getToken()->getUser()->getTree()->getPeoples();


		$tree = $this->container->get('security.token_storage')
			->getToken()->getUser()->getTree();

		//ajoute une personne
		$people = new People();
		$form = $this->createForm(PeopleFormType::class, $people);
		$form->handleRequest($request);
			if($form->isSubmitted() && $form->isValid()){

				$people->setTree($tree);
				$em = $this->getDoctrine()->getManager();

				$em->persist($people);  //constitue l'objet
				$em->persist($tree);
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
        // Récupération de l'ID dans la requete
        $id = $request->get('id');

        // On crée l'entity manager pour pouvoir y trouver l'id correspondant
        $em = $this->getDoctrine()->getManager();
        $people = $em->getRepository('DLFamilytreeBundle:People')->find($id);

        // Création du formulaire pour changer les données, en utilisant un template FormType prérempli avec les données de people
        $form = $this->createForm(PeopleFormType::class, $people);

        // Les données du formulaire soumis sont transmises
        $form->handleRequest($request);
        // On verifie que le formulaire est valide, une autre méthode plus pérènne serait d'utiliser | if (Form::isSubmitted() && Form::isValid()) | car Form::isValid()) sera bientôt deprécié
        if($form->isValid()) {

            // $data = $form->getData();
						//
            // $file = $people->getImageFile();

            // Ecriture des changement en BDD

            $em->flush();
            // Redirection vers la page people
            return $this->redirectToRoute('people');
        }
        // On passe le formulaire à la vue pour affichage
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
