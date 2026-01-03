<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    public $class;
    public $type;
    public $label;
    public $name;
    public $placeholder;
    public $required;
    public $value;
    
    public function __construct(
        $type,
        $label,
        $name,
        $placeholder = '',
        $required = false,
        $class = '',
        $value = '',
    ) {
        $this->type = $type;
        $this->label = $label;
        $this->name = $name;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->class = 'form_input ' . $class;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input');
    }
}
