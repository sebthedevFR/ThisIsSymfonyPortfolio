<?php

namespace PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\ArrayCollection;
use PortfolioBundle\Entity\Projet;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

use PortfolioBundle\Entity\Message;

class PortfolioController extends Controller
{
    public function indexAction(Request $request)
    {

        //On rvers la page de visualisation de la page crée
        // récup de l'id de la pharm
        //la commande est de type get
        //on retourne la vue ajouter qui contiendras le formulaire
        // récupération de la liste des portfolio
        // --------------
        $repository = $this->getDoctrine()->getManager()->getRepository('PortfolioBundle:Projet');

        $listProjet=$repository->findAll();

        // récupération de la liste des quotess

        $repositoryQuotes = $this->getDoctrine()->getManager()->getRepository('PortfolioBundle:Quotes');

        $listQuotes=$repositoryQuotes->findAll();

        $numberOfQuotes = count($listQuotes);
        $randomQuoteNumber = rand(1,$numberOfQuotes);

        //la demande est de type post = (=soumission du formulaire de création d'une pharmacie)?
        //ou de type get = demande d'affichage du formulaire de création d'une pharmacie)???
        //-----------------------------------------------
        if ($request->isMethod('POST'))
        {
            //la demande est de type POST
            //Récupération des informations saisies dans le formulaire
            //Et creation de la pharmacie dans la base de données
            // On crée un objet instance de pharmacie
            $unMessage = new Message();
            $firstName = $request->get('firstname');
            if ($firstName == null)
            {
                $firstName = "VIDE";
            }
            $unMessage->setFirstName($firstName);
            $lastName = $request->get('lastname');
            if ($lastName == null)
            {
                $lastName = "VIDE";
            }
            $unMessage->setLastName($lastName);
            $email = $request->get('email');
            if ($email == null)
            {
                $email = "VIDE";
            }
            $unMessage->setEmail($email);
            $leMessage = $request->get('message');
            if ($leMessage == null)
            {
                $firstName = "VIDE";
            }
            $unMessage->setMessage($leMessage);



            // On récupére le service EntityManager géré par le service Doctrine
            $em = $this->getDoctrine()->getManager();

            // On pérsiste l'entité
            $em->persist($unMessage);

            // On flush tout ce qui a été persisté avant
            $em->flush();

            // affichage d'une message flash pour indiquer que la pharmacie à bien était ajoutée
            $this->addFlash('notice','Your message has been send.');
            return $this->render('PortfolioBundle:Portfolio:index.html.twig', array('lesProjets'=>$listProjet, 'lesQuotes'=>$listQuotes, 'randomQuoteNumber'=>$randomQuoteNumber));
        }
        else
        {

            return $this->render('PortfolioBundle:Portfolio:index.html.twig', array('lesProjets'=>$listProjet, 'lesQuotes'=>$listQuotes, 'randomQuoteNumber'=>$randomQuoteNumber));
        }


    }
    public function afficherUnPortAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $projetRepository = $em->getRepository('PortfolioBundle:Projet');
        $unProjet = $projetRepository->find($id);

        $documentRepository = $em->getRepository('PortfolioBundle:Document');
        $lesDocuments = $documentRepository->findBy(
            array('leProjet' => $id)
        );

        return $this->render('PortfolioBundle:Portfolio:afficherUnPort.html.twig', array('unProjet'=>$unProjet, 'lesDocuments'=>$lesDocuments));
    }


}
