<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FlipCounter extends Component
{
    public $counter;
    public $title;
    public $icon;
    public function __construct($counter,$title,$icon)
    {
        $this->title = $title;
        $this->icon = $icon;
        $this->counter = preg_split('//', (string)$counter, -1, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.flip-counter');
    }
}
