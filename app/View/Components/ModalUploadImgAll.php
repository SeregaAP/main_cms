<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ModalUploadImgAll extends Component
{
    public string $inputSelector;
    
    /**
     * Create a new component instance.
     */
    public function __construct(string $inputSelector = '')
    {
        $this->inputSelector = $inputSelector;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal-upload-img-all', [
            'inputSelector' => $this->inputSelector
        ]);
    }
}
