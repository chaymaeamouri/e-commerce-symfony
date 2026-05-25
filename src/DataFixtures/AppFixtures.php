<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Add a test user
        $user = new User();
        $user->setEmail('admin@test.com');
        $user->setFirstName('Chaymae');
        $user->setLastName('Amouri');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->passwordHasher->hashPassword($user, 'admin123'));
        $manager->persist($user);

        $categories = [
            'Électronique' => 'electronique',
            'Mode' => 'mode',
            'Maison & Jardin' => 'maison-jardin',
            'Sports' => 'sports',
            'Livres' => 'livres'
        ];

        $categoryEntities = [];
        foreach ($categories as $name => $slug) {
            $category = new Category();
            $category->setName($name);
            $manager->persist($category);
            $categoryEntities[$name] = $category;
        }

        $products = [
            [
                'name' => 'Casque Sans Fil Premium',
                'price' => 299.99,
                'category' => 'Électronique',
                'image' => 'headphones.jpg',
                'description' => 'Découvrez un son cristallin avec notre casque sans fil haut de gamme. Doté d\'une réduction de bruit active et d\'une autonomie de 40 heures.'
            ],
            [
                'name' => 'Veste en Cuir Classique',
                'price' => 189.99,
                'category' => 'Mode',
                'image' => 'jacket.jpg',
                'description' => 'Fabriquée à la main en cuir véritable, cette veste offre un look intemporel qui se bonifie avec le temps.'
            ],
            [
                'name' => 'Plante d\'Intérieur Minimaliste',
                'price' => 45.00,
                'category' => 'Maison & Jardin',
                'image' => 'plant.jpg',
                'description' => 'Une magnifique plante d\'intérieur facile à entretenir qui ajoute une touche de nature et de fraîcheur à tout espace moderne.'
            ],
            [
                'name' => 'Tapis de Yoga Professionnel',
                'price' => 55.00,
                'category' => 'Sports',
                'image' => 'yoga.jpg',
                'description' => 'Tapis de yoga écologique et antidérapant, conçu pour une adhérence et un confort optimaux lors de vos séances les plus intenses.'
            ],
            [
                'name' => 'Enceinte Bluetooth Studio',
                'price' => 129.99,
                'category' => 'Électronique',
                'image' => 'speaker.jpg',
                'description' => 'Un son puissant dans un design compact et élégant. Se connecte instantanément à tous vos appareils.'
            ],
            [
                'name' => 'Guide Complet Développeur Full-Stack',
                'price' => 39.99,
                'category' => 'Livres',
                'image' => 'book.jpg',
                'description' => 'Le guide ultime pour maîtriser le développement web moderne. Apprenez React, Node.js et Symfony de zéro.'
            ],
            [
                'name' => 'Souris Sans Fil Ergonomique',
                'price' => 69.99,
                'category' => 'Électronique',
                'image' => 'mouse.jpg',
                'description' => 'Conçue pour un confort et une précision durables. Parfaite pour les flux de travail professionnels et créatifs.'
            ],
            [
                'name' => 'T-shirt en Coton Premium',
                'price' => 25.00,
                'category' => 'Mode',
                'image' => 'tshirt.jpg',
                'description' => 'Doux, respirant et issu de sources durables. Un essentiel de garde-robe pour un style quotidien.'
            ]
        ];

        foreach ($products as $pData) {
            $product = new Product();
            $product->setName($pData['name']);
            $product->setPrice($pData['price']);
            $product->setImage($pData['image']);
            $product->setDescription($pData['description']);
            $product->setCategory($categoryEntities[$pData['category']]);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
