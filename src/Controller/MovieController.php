<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MovieController extends AbstractController
{
    private const MOVIES = [
        1 => [
            'id' => 1,
            'title' => 'Inception',
            'year' => 2010,
            'description' => 'Вор, который крадёт секреты через сны, получает задание внедрить идею в сознание человека.',
        ],
        2 => [
            'id' => 2,
            'title' => 'The Matrix',
            'year' => 1999,
            'description' => 'Программист узнаёт, что реальный мир оказался компьютерной симуляцией.',
        ],
        3 => [
            'id' => 3,
            'title' => 'Interstellar',
            'year' => 2014,
            'description' => 'Группа астронавтов отправляется через червоточину на поиски нового дома для человечества.',
        ],
    ];

    #[Route('/movies', name: 'movie_index')]
    public function index(): Response
    {
        return $this->render('movie/index.html.twig', [
            'movies' => self::MOVIES,
        ]);
    }

    #[Route('/movies/random', name: 'movie_random')]
    public function random(): Response
    {
        return $this->render('movie/show.html.twig', [
            'movie' => self::MOVIES[array_rand(self::MOVIES)],
        ]);
    }

    #[Route('/movies/{id}', name: 'movie_show', requirements: ['id' => '\d+'])]
    public function show(int $id): Response
    {
        if (!isset(self::MOVIES[$id])) {
            throw $this->createNotFoundException('Фильм не найден');
        }

        return $this->render('movie/show.html.twig', [
            'movie' => self::MOVIES[$id],
        ]);
    }
}