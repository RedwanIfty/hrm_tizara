<?php

namespace App\View\Components\UserProfile;

use Illuminate\View\Component;

class FamilyInformation extends Component
{
    public $familyInformations;
    public $user;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($familyInformations,$user)
    {
        $this->familyInformations=$familyInformations;
        $this->user=$user;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.user-profile.family-information');
    }
}
