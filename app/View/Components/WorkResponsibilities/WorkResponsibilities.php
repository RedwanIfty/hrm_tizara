<?php

namespace App\View\Components\WorkResponsibilities;

use Illuminate\View\Component;

class WorkResponsibilities extends Component
{
    public $users;
//    public $workResponsibilities;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($users)
    {
        //
        $this->users = $users;
//        $this->workResponsibilities = $workResponsibilities;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.work-responsibilities.work-responsibilities');
    }
}