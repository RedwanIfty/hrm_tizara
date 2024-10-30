<?php
// app/View/Components/UserProfile/BankInfo.php

namespace App\View\Components\UserProfile;

use Illuminate\View\Component;
use App\Models\BankInformation;
use Illuminate\Support\Facades\Auth;

class BankInfo extends Component
{
    public $bankInfo;

    public function __construct()
    {
        // Retrieve bank information for the authenticated user
        $this->bankInfo = BankInformation::where('user_id', Auth::id())->first();
    }

    public function render()
    {
        return view('components.user-profile.bank-info');
    }
}
