<?php

namespace App\Http\Livewire;

use Livewire\Component;

class MyNavigationMenu extends Component
{
    /**
     * The component's listeners.
     *
     * @var array
     */
    protected $listeners = [
        'refresh-navigation-menu' => '$refresh',
    ];

    public function render()
    {
        $prefix = "";
        // urlからユーザーを取得
        $user = \Str::of(\Request::path())->before('/');
        if (in_array($user, ['cms'])) {
            $prefix = "cms.";
        }
        return view('navigation-menu')->with([
            "prefix" => $prefix
        ]);
    }
}
