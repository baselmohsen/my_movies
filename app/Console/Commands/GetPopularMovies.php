<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Actor;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Support\Facades\Http;
class GetPopularMovies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:popularMovies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get all movues from tmdb ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

            $response = Http::get('https://api.themoviedb.org/3/movie/popular?region=us&api_key=00aad8be2a82e3a4d342cbc7d25afc24&page=1');

            foreach ($response->json()['results'] as $result) {

                $movie = Movie::updateOrCreate(
                    [
                        'e_id' => $result['id'],
                        'title' => $result['title'],
                    ],
                    [
                        'description' => $result['overview'],
                        'poster' => $result['poster_path'],
                        'banner' => $result['backdrop_path'],
                        'release_date' => $result['release_date'],
                        'vote' => $result['vote_average'],
                        'vote_count' => $result['vote_count'],
                    ]);

             

    }
}
