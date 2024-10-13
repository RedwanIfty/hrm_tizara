<?php

namespace App\View\Components\WorkResponsibilitiesModal;

use Illuminate\View\Component;

class WorkResponsibilitiesModal extends Component
{
    public $users;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($users)
    {
        $this->users = $users;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.work-responsibilities-modal.work-responsibilities-modal');
    }
}