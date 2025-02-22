<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Http\Controllers\DepartmentController;

class DepartmentsComponent extends Component
{

    public $departmentData;

    public function __construct()
    {
        $departmentController = new DepartmentController();
        $this->departmentData = $departmentController->getData();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.departments-component');
    }
}
