<?php

namespace App\View\Components\UserProfile;

use Illuminate\View\Component;

class Experience extends Component
{
    public $experience;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($experience)
    {
        $this->experience=$experience;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.user-profile.experience');
    }
}
