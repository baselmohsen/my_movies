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

                $this->attachGenres($result, $movie);

                $this->attachActors($movie);

                $this->getImages($movie);

            }//end of for each
        
           private function attachGenres($result, Movie $movie)
    {
        foreach ($result['genre_ids'] as $genreId) {

            $genre = Genre::where('e_id', $genreId)->first();

            $movie->genres()->syncWithoutDetaching($genre->id);

        }//end of for each

    }// end of attachGenres

    private function attachActors(Movie $movie)
    {
        $response = Http::get(config('services.tmdb.base_url') . '/movie/' . $movie->e_id . '/credits?api_key=' . config('services.tmdb.api_key'));

        foreach ($response->json()['cast'] as $index => $cast) {

            if ($cast['known_for_department'] != 'Acting') continue;

            if ($index == 12) break;

            $actor = Actor::where('e_id', $cast['id'])->first();

            if (!$actor) {

                $actor = Actor::create([
                    'e_id' => $cast['id'],
                    'name' => $cast['name'],
                    'image' => $cast['profile_path'],
                ]);

            }//end of if

            $movie->actors()->syncWithoutDetaching($actor->id);

        }//end of for each

    }// end of attachActors

    public function getImages(Movie $movie)
    {
        $response = Http::get(config('services.tmdb.base_url') . '/movie/' . $movie->e_id . '/images?api_key=' . config('services.tmdb.api_key'));

        $movie->images()->delete();

        foreach ($response->json()['backdrops'] as $index => $im) {

            if ($index == 8) break;

            $movie->images()->create([
                'image' => $im['file_path']
            ]);

        }//end of for each

    }// end of getImages

    }
}
