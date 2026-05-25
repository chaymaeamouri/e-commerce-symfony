<?php

namespace App\Controller;

use App\Service\CartHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * Ajoute un produit au panier (ou incrémente sa quantité s'il y est déjà).
     */
    #[Route('/cart/add/{id}', name: 'cart_add')]
    public function add(int $id, CartHandler $cart): Response
    {
        $cart->add($id);
        $this->addFlash('success', 'Produit ajouté au panier !');
        return $this->redirectToRoute('app_cart');
    }

    /**
     * Supprime complètement un produit du panier, peu importe sa quantité.
     */
    #[Route('/cart/remove/{id}', name: 'cart_remove')]
    public function remove(int $id, CartHandler $cart): Response
    {
        $cart->remove($id);
        $this->addFlash('info', 'Produit retiré du panier.');
        return $this->redirectToRoute('app_cart');
    }

    /**
     * Décrémente la quantité d'un produit dans le panier (en retire un seul).
     */
    #[Route('/cart/decrement/{id}', name: 'cart_decrement')]
    public function decrement(int $id, CartHandler $cart): Response
    {
        $cart->decrement($id);
        return $this->redirectToRoute('app_cart');
    }

    /**
     * Vide intégralement le panier.
     */
    #[Route('/cart/clear', name: 'cart_clear')]
    public function clear(CartHandler $cart): Response
    {
        $cart->clear();
        return $this->redirectToRoute('app_cart');
    }
}
