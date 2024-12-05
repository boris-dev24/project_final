<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('books')->insert([
            [
                'title' => 'La Ricaneuse',
                'author' => 'Eric Dupont',
                'year' => 2024,
                'summary' => 'Saga familiale montréalaise qui prend racine dans les fermes au pied du mont Royal où se cultive le melon brodé à la fin du 19e siècle, La Ricaneuse navigue entre Mary Gallagher, célèbre fantôme de Griffintown, le tavernier Charles McKiernan, ami des démunis et montreur d’ours, et un mystérieux enfant prophète qui produit des dessins futuristes.',
                'price' => 35.95,
                'image_path' => '/images/laricaneuse.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Cent ans d’amour',
                'author' => 'Janette',
                'year' => 2023,
                'summary' => 'Janette Bertrand, notre Janette, aura très bientôt 100 ans. Pour souligner un siècle d\'amour, elle nous offre sa vision de la vieillesse ainsi que ses réflexions sur l\'âgisme et sur les difficultés de vieillir, mais aussi, et surtout, sur les petits plaisirs du grand âge.',
                'price' => 24.95,
                'image_path' => '/images/centansdamour.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Les Yeux de Mona',
                'author' => 'Thomad Schlesser',
                'year' => 2024,
                'summary' => 'Cinquante-deux semaines : c\'est le temps qu\'il reste à Mona pour découvrir toute la beauté du monde. C\'est le temps que s\'est donné son grand-père, un homme érudit et fantasque, pour l\'initier, chaque mercredi après l\'école, à une œuvre d\'art, avant qu\'elle ne perde, peut-être pour toujours, l\'usage de ses yeux..',
                'price' => 36.95,
                'image_path' => '/images/lesyeuxdemona.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Jamais Plus',
                'author' => 'Collen Hoover',
                'year' => 2024,
                'summary' => 'Entre un père violent et une mère soumise, Lily Blossom Bloom n\'a pas eu une enfance très facile, mais elle a su s\'en sortir, et est à l\'aube de réaliser le rêve de sa vie, ouvrir une boutique de fleurs à Boston.',
                'price' => 24.99,
                'image_path' => '/images/jamaisplus.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Entre nous: mieux se connaitre, mieux s\'aimer.',
                'author' => 'Sophie Gregoire Trudeau',
                'year' => 2024,
                'summary' => 'ENTRE NOUS est un livre axé sur la connaissance de soi. Il explore l’importance de mieux comprendre nos émotions et les mécanismes de notre personnalité afin de maintenir une bonne santé mentale tant sur le plan individuel que collectif.',
                'price' => 39.95,
                'image_path' => '/images/entrenous.jpg',
                'created_at' => now(),
                'updated_at' => now(),



            ],
            [
                'title' => 'Tenir debout.',
                'author' => 'Melissa Da Costa',
                'year' => 2024,
                'summary' => 'Tenir debout . Jusqu\'où peut-on aimer ? Jusqu\'à s\'oublier.... Le nouveau roman de Mélissa Da Costa nous plonge au cœur de l\'intimité d\'un couple en miettes et affronte, avec une force inouïe, la réalité de l\'amour, du désespoir, et la soif de vivre, malgré les épreuves',
                'price' => 36.95,
                'image_path' => '/images/tenirdebout.jpg',
                'created_at' => now(),
                'updated_at' => now(),

            ],
            [

                'title' => 'La nuit de ta disparition .',
                'author' => 'Victoria Charlton',
                'year' => 2024,
                'summary' => 'Après avoir retrouvé les têtes des victimes du tueur Robert Peters, Mackenzie s\'envole pour Paris. Mais son voyage est écourté par des révélations troublantes entourant le suicide de sa mère.',
                'price' => 27.95,
                'image_path' => '/images/lanuitdetadisparition.jpg',
                'created_at' => now(),
                'updated_at' => now(),


            ],
        ]);
    }
}
