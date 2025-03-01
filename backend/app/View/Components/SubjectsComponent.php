<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Auth;

class SubjectsComponent extends Component
{
    public $subjectData;

    public function __construct()
    {
        $subjectController = new SubjectController();
        $this->subjectData = $subjectController->getData();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.subjects-component');
    }
}
