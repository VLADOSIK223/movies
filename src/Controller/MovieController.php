<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MovieController extends AbstractController
{
    private function getMovies(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'Inception',
                'year' => 2010,
                'description' => 'Вор, который крадёт секреты через сны, получает задание внедрить идею в сознание человека.',
            ],
            [
                'id' => 2,
                'title' => 'The Matrix',
                'year' => 1999,
                'description' => 'Программист узнаёт, что реальный мир оказался компьютерной симуляцией.',
            ],
            [
                'id' => 3,
                'title' => 'Interstellar',
                'year' => 2014,
                'description' => 'Группа астронавтов отправляется через червоточину на поиски нового дома для человечества.',
            ],
        ];
    }

    #[Route('/movies', name: 'movie_index')]
    public function index(): Response
    {
        $movies = $this->getMovies();

        return $this->render('movie/index.html.twig', [
            'movies' => $movies,
        ]);
    }

    #[Route('/movies/random', name: 'movie_random')]
    public function random(): Response
    {
        $movies = $this->getMovies();
        $movie = $movies[array_rand($movies)];

        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
        ]);
    }

    #[Route('/movies/{id}', name: 'movie_show', requirements: ['id' => '\d+'])]
    public function show(int $id): Response
    {
        $movies = $this->getMovies();
        $found = null;

        foreach ($movies as $movie) {
            if ($movie['id'] == $id) {
                $found = $movie;
            }
        }

        if ($found === null) {
            throw $this->createNotFoundException('Фильм не найден');
        }

        return $this->render('movie/show.html.twig', [
            'movie' => $found,
        ]);
    }
}