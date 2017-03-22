<?php

namespace PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\ArrayCollection;
use PortfolioBundle\Entity\Projet;

class PortfolioController extends Controller
{
    public function indexAction()
    {
        // récupération de la liste des portfolio
        // --------------
        $repository = $this->getDoctrine()->getManager()->getRepository('PortfolioBundle:Projet');

        $listProjet=$repository->findAll();

        // récupération de la liste des quotess

        $repositoryQuotes = $this->getDoctrine()->getManager()->getRepository('PortfolioBundle:Quotes');

        $listQuotes=$repositoryQuotes->findAll();

        $numberOfQuotes = count($listQuotes);
        $randomQuoteNumber = rand(1,$numberOfQuotes);



        // On demande à la vue d'afficher la liste des pharmacie


        return $this->render('PortfolioBundle:Portfolio:index.html.twig', array('lesProjets'=>$listProjet, 'lesQuotes'=>$listQuotes, 'randomQuoteNumber'=>$randomQuoteNumber));


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
//    public function afficherListePortAction()
//    {
//        // récupération de la liste des portfolio
//        // --------------
//        $repository = $this->getDoctrine()->getManager()->getRepository('PortfolioBundle:Projet');
//
//        $listProjet=$repository->findAll();
//
//        // On demande à la vue d'afficher la liste des pharmacie
//
//        return $this->render('PortfolioBundle:afficherLesPorts.html.twig', array('lesProjets'=>$listProjet));
//
//    }
}
