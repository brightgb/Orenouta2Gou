<?php
namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Library\AdminAuthority;

class AdminComposer
{
    protected $my;

    public function __construct()
    {
        $this->my = \Auth::user();
    }

    public function compose(View $view)
    {
        $route = str_replace( 'admin::', '', \Route::current()->getName());
        $camPermit = AdminAuthority::AuthorityCURD(explode('.', $route)[0]);
        $view->with([
            'my'           => $this->my,
            'createPermit' => $camPermit['createPermit'],
            'editPermit'   => $camPermit['editPermit'],
            'showPermit'   => $camPermit['showPermit'],
            'deletePermit' => $camPermit['deletePermit'],
        ]);
    }
}