<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Comment extends Component
{
    public $movie;
    public $comments;
    public $commentCount;

    public function __construct($movie, $comments, $commentCount)
    {
        $this->movie = $movie;
        $this->comments = $comments;
        $this->commentCount = $commentCount;
    }

    public function render()
    {
        return view('components.comment');
    }
}
