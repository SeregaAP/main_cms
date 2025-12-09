<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Link extends Component
{
    public $href;
    public $class;
    public $nameList; // <- camelCase
    public $active;

    public function __construct($href = '#', $class = '', $nameList = '',$active = '')
    {
        $this->href = $href;
        $this->class = $class;
        $this->nameList = $nameList;
        $this->active = $active;
    }

    public function render()
    {
        return view('components.link');
    }
}
