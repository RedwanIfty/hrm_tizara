<?php

namespace App\View\Components\FilesAdd;

use Illuminate\View\Component;

class FilesAdd extends Component
{
    public $users;
    public $fileTypes;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($users, $fileTypes)
    {
        $this->users = $users;
        $this->fileTypes = $fileTypes;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.files-add.files-add');
    }
}
