<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
	#[Route('/products', name: 'product_index')]
	public function index(ProductRepository $productRepository): Response
	{
		return $this->render('product/index.html.twig', [
			'products' => $productRepository->findBy([], ['createdAt' => 'DESC']),
		]);
	}
	
	#[Route('products/{id}', name: 'product_show')]
	public function show(Product $product): Response
	{
		return $this->render('product/show.html.twig', [
			'product' => $product
		]);
	}
	
	#[Route('product/new', name: 'product_new')]
	public function new(Request $request, EntityManagerInterface $manager): Response
	{
		
		$product = new Product();
		
		$form = $this->createForm(ProductType::class, $product);
		
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			$manager->persist($product);
			$manager->flush();
			
			$this->addFlash(
				'notice',
				'Product has been created'
			);
			
			return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
			
		}
		
		return $this->render('product/new.html.twig', [
			'form' => $form,
		]);
	}
	
	#[Route('product/{id}/edit', name: 'product_edit')]
	public function edit(Product $product, Request $request, EntityManagerInterface $manager): Response
	{
		
		$form = $this->createForm(ProductType::class, $product);
		
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			$manager->flush();
			
			$this->addFlash(
				'notice',
				'Product has been updated'
			);
			
			return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
			
		}
		
		return $this->render('product/edit.html.twig', [
			'form' => $form,
			'product' => $product,
		]);
	}
	
	#[Route('product/{id}/delete', name: 'product_delete')]
	public function delete(Product $product, Request $request, EntityManagerInterface $manager): Response
	{
		
		if ($request->isMethod('POST')) {
			$manager->remove($product);
			$manager->flush();
			$this->addFlash(
				'notice',
				'Product has been deleted'
			);
			
			return $this->redirectToRoute('product_index');
		}
		
		return $this->render('product/delete.html.twig', [
			'product' => $product,
		]);
	}
}
