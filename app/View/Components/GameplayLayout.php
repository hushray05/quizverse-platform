<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class GameplayLayout extends Component
{
    public function __construct(
        public $quiz = null
    ) {}

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.gameplay');
    }
}
