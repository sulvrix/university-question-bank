<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Http\Controllers\UserController;

class UsersComponent extends Component
{
    public $userData;

    public function __construct()
    {
        $userController = new UserController();
        $this->userData = $userController->Index();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.users-component');
    }
}
