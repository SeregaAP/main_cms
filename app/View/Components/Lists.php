<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Lists extends Component
{
    public $class;
    public $name;
    /**
     * Create a new component instance.
     */
    public function __construct($class = '',$name = '')
    {
        $this->class = $class;
        $this->name = $name;
    }

    public function render()
    {
        return view('components.lists');
    }
}
