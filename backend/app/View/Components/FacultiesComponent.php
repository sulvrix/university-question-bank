<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Http\Controllers\FacultyController;

class FacultiesComponent extends Component
{
    public $facultyData;

    public function __construct()
    {
        $facultyController = new FacultyController();
        $this->facultyData = $facultyController->getData();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.faculties-component');
    }
}
