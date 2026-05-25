<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use App\Service\CartHandler;
use Symfony\Component\HttpFoundation\Request;

class MainController extends AbstractController
{
    /**
     * Affiche la page d'accueil avec la liste de tous les produits.
     */
    #[Route('/', name: 'app_home')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->render('index.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * Affiche le profil de l'utilisateur connecté.
     * Accessible uniquement si l'utilisateur a le rôle ROLE_USER.
     */
    #[Route('/profile', name: 'app_profile')]
    #[IsGranted('ROLE_USER')]
    public function profile(): Response
    {
        return $this->render('profile.html.twig');
    }

    /**
     * Affiche les détails d'un produit spécifique en fonction de son ID.
     */
    #[Route('/product/{id}', name: 'app_product_details')]
    public function productDetails(int $id, ProductRepository $productRepository): Response
    {
        $product = $productRepository->find($id);
        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }
        return $this->render('product_details.html.twig', [
            'product' => $product
        ]);
    }

    /**
     * Affiche la liste de toutes les catégories disponibles.
     */
    #[Route('/categories', name: 'app_categories')]
    public function categories(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('browse_categories.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * Affiche le contenu actuel du panier de l'utilisateur.
     */
    #[Route('/cart', name: 'app_cart')]
    public function cart(CartHandler $cart): Response
    {
        return $this->render('cart.html.twig', [
            'items' => $cart->getFullCart(),
            'total' => $cart->getTotal()
        ]);
    }

    /**
     * Affiche tous les produits associés à une catégorie spécifique.
     */
    #[Route('/category/{id}', name: 'app_products_by_category')]
    public function productsByCategory(int $id, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->find($id);
        if (!$category) {
            throw $this->createNotFoundException('Category not found');
        }
        return $this->render('products_by_category.html.twig', [
            'category' => $category,
            'products' => $category->getProducts()
        ]);
    }
}
