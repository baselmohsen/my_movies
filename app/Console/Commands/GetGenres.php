<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Genre;
use Illuminate\Support\Facades\Http;
class GetGenres extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:genres';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get all genres from tmdb ';

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
        $response = Http::get('https://api.themoviedb.org/3/genre/movie/list?api_key=00aad8be2a82e3a4d342cbc7d25afc24');

        foreach ($response->json()['genres'] as $genre) {

            Genre::updateOrCreate(
                [
                    'e_id' => $genre['id'],
                ],
                [
                    'name' => $genre['name']
                ]);
            }
    }
}
