<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController {

    /**
    * @var PropertyRepository
    */
    private $repository;

    /**
    * @var ObjectManager 
    */
    private $em;

    public function __construct(PropertyRepository $Repository, ObjectManager $Em) {
        $this->repository = $Repository;
        $this->em = $Em;
    }

    /**
     * @Route("biens", name="property.index")
     * @param Property $property
     * @return Response
     */
    public function index () :Response {
        
        /* 1
        $property = new Property();
        $property->setTitle('Mon premier bien')
            ->setPrice(200000)
            ->setRooms(4)
            ->setBadRooms(3)
            ->setDescription('...desc')
            ->setSurface(60)
            ->setFloor(4)
            ->setHeat(1)
            ->setCity('Namur')
            ->setAddress('55 Henri Lecocq')
            ->setPostalCode('5000');
        $em = $this->getDoctrine()->getManager();
        $em->persist($property);
        $em->flush(); */

        /* 2
        $repository = $this->getDoctrine()->getRepository(Property::class);
        dump($repository);
        */

        /* 3 
        //$property = $this->repository->find(1); // recupère le record à l'id 1
        //$property = $this->repository->findAll(); // recupère un tableau avec tous les record de la table property
        //$property = $this->repository->findOneBy(['floor' => 4]); // récupère tous les records ou floor = 4
        $property = $this->repository->findAllVisible(); // methode personnalisé dans PropertyRepository 
        dump($property);
        $property[0]->setSold(true);
        $this->em->flush();
        */
        return $this->render('property/index.html.twig',
            [ 'current_menu' => 'property']);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements ={ "slug": "[a-z0-9\-]*" })
     * @param Property $property
     * @return Response
     */
    public function show (Property $property, string $slug) :Response 
    {
        if($property->getSlug() !== $slug) {
            return $this->redirectToRoute('property.show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }

        return $this->render('property/show.html.twig',[   
                'property' => $property,
                'current_menu' => 'property.show'
            ]);
    }
}