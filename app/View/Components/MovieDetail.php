<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MovieDetail extends Component
{
    public $movie;
    public $existingWatchList;
    public $averageRating;
    public $memberRating;

    public function __construct($movie, $existingWatchList, $averageRating, $memberRating)
    {
        $this->movie = $movie;
        $this->existingWatchList = $existingWatchList;
        $this->averageRating = $averageRating;
        $this->memberRating = $memberRating;
    }

    public function render()
    {
        return view('components.movie-detail');
    }
}
