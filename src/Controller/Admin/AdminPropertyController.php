<?php

namespace App\Controller\Admin;

use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use App\Entity\Property;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends AbstractController{

    private $_propertyRepository;

    /**
     * @param PropertyRepository $PropertyRepository
     */
    public function __construct(PropertyRepository $PropertyRepository) {
        $this->_propertyRepository = $PropertyRepository;
    }

    /**
     * @Route("admin", name="admin.property.index")
     * @return Render
     */
    public function index() {
        $properties = $this->_propertyRepository->findAll();
        return $this->render('admin/property/index.html.twig', compact('properties'));
    }

     /**
     * @Route("/admin/{id}", name="admin.property.edit")
     * @param PropertyRepository $PropertyRepository
     * @return Render
     */
    public function edit(PropertyRepository $PropertyRepository,Property $PropertyEntity, int $id) {
        $form = $this->createForm(PropertyType::class, $PropertyEntity);
        $property = $this->_propertyRepository->find($id);
        return $this->render('admin/property/edit.html.twig', [
            compact('property'),
            'form' => $form->createView()
        ]);
    }
}