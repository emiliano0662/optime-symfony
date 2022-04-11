<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Product;
use App\Form\ProductType;

use App\Entity\Category;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProductController extends AbstractController
{

    /**
     * Dashboard Main
     */

    public function index(ManagerRegistry $doctrine)
    {
        $products = $doctrine->getRepository(Product::class)->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * Create product
     */

    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $category = $doctrine->getRepository(Category::class)->findAll();

        $product = new Product();

        $form = $this->createForm(ProductType::class, $product)
            ->add('category', ChoiceType::class, ['choices' => $category, 'placeholder' => 'Elige una opción', 'choice_label' => 'name', 'choice_value' => 'id', 'required' => false]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $dateImmutable = new \DateTimeImmutable('now');
            
            $product->setCreatedAt($dateImmutable);
            $product->setUpdatedAt($dateImmutable);
            
            $entityManager = $doctrine->getManager();

            $entityManager->persist($product);

            $entityManager->flush();

            $this->addFlash('notice', '¡Tus cambios fueron guardados!');

            return $this->redirectToRoute('index');
        }

        return $this->renderForm('product/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Edit product
     */
    public function edit(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $product = $doctrine->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException('No product found');
        }

        $category = $doctrine->getRepository(Category::class)->findAll();

        $form = $this->createForm(ProductType::class, $product)
            ->add('category', ChoiceType::class, ['choices' => $category, 'placeholder' => 'Elige una opción', 'choice_label' => 'name', 'choice_value' => 'id', 'required' => false]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $dateImmutable = new \DateTimeImmutable('now');
            
            $product->setUpdatedAt($dateImmutable);
            
            $entityManager = $doctrine->getManager();

            $entityManager->persist($product);

            $entityManager->flush();

            $this->addFlash('notice', '¡Tus cambios fueron guardados!');

            return $this->redirectToRoute('index');
        }

        return $this->renderForm('product/edit.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Delete product
     */
    public function delete(ManagerRegistry $doctrine, int $id): Response
    {   
        $product = $doctrine->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException('No product found');
        }

        $entityManager = $doctrine->getManager();

        $entityManager->remove($product);
        $entityManager->flush();

        $this->addFlash('notice', '¡Tus cambios fueron guardados!');

        return $this->redirectToRoute('index');
    }
}
