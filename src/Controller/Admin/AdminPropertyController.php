<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AdminPropertyController extends AbstractController
{

    private $_propertyRepository;
    private $_em;

    /**
     * @param PropertyRepository $PropertyRepository
     * @param ObjectManager $em
     */
    public function __construct(PropertyRepository $PropertyRepository, ObjectManager $em)
    {
        $this->_propertyRepository = $PropertyRepository;
        $this->_em = $em;
    }

    /**
     * @Route("admin", name="admin.property.index")
     * @return Render
     */
    public function index()
    {
        $properties = $this->_propertyRepository->findAll();
        return $this->render('admin/property/index.html.twig', compact('properties'));
    }

    /**
     * @Route("/admin/property/create", name="admin.property.new")
     * @param PropertyRepository $PropertyRepository
     * @param Request $request
     */
    public function new(
        PropertyRepository $PropertyRepository,
        Request $request
    ) {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->_em->persist($property);
            $this->_em->flush();
            $this->addFlash('success', 'Bien créé avec succès');
            return $this->redirectToRoute('admin.property.index');
        }

        return $this->render('admin/property/new.html.twig', [
            'property' => $PropertyRepository,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/{id}", name="admin.property.edit", methods="GET|POST")
     * @param PropertyRepository $PropertyRepository
     * @param Request $request
     * @return Render
     */
    public function edit(
        PropertyRepository $PropertyRepository,
        Property $PropertyEntity,
        Request $request,
        int $id
    ) {
        $form = $this->createForm(PropertyType::class, $PropertyEntity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->_em->flush();
            $this->addFlash('success', 'Bien modifié avec succès');
            return $this->redirectToRoute('admin.property.index');
        }

        $property = $this->_propertyRepository->find($id);
        return $this->render('admin/property/edit.html.twig', [
            compact('property'),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/property/{id}", name="admin.property.delete", methods="DELETE")
     * @param Property $property
     * @param Request $request
     * @return Response
     */
    public function delete(Property $property, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))){
            $this->_em->remove($property);
            $this->addFlash('success', 'Bien supprimé avec succès');
            $this->_em->flush();
        }
        return $this->redirectToRoute('admin.property.index');
        
    }
}
