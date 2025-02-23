<?php

namespace App\View\Components;

use App\Http\Controllers\QuestionController;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class questionsComponent extends Component
{
    public $questionData;

    public function __construct()
    {
        $questionController = new QuestionController();
        $this->questionData = $questionController->getData();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.questions-component');
    }
}
