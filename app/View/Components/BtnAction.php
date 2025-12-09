<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BtnAction extends Component
{
    public $doc;
    public $route;
    public $type;

    public function __construct($doc, $route, $type)
    {
        $this->doc = $doc;
        $this->route = $route;
        $this->type = $type;
    }

    public function render()
    {
        return view('components.btn-action');
    }
}
