<?php

namespace App\View\Components;

use App\Models\Character;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class Navbar extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $bot = Character::where(['user_id'=>Auth::id(), 'code'=>request()->bot])->first();
        return view('components.navbar', compact('bot'));
    }
}
