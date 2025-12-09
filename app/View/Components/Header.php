<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Header extends Component
{
    public $titleHeader;
    public $class;
    public $buttons; // массив кнопок

    public function __construct($titleHeader = '', $class = '', $buttons = [])
    {
        $this->titleHeader = $titleHeader;
        $this->class = $class;
        $this->buttons = $buttons;
    }

    public function render()
    {
        return view('components.header');
    }
}