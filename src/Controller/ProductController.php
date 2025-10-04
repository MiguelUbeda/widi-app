<?php

namespace App\Controller;

use App\Document\Product;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/', name: 'app_products')]
    public function index(DocumentManager $dm): Response
    {
        $products = $dm->getRepository(Product::class)->findTop10();

        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }
}
