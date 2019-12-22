<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        \View::composers([
            \App\Http\ViewComposers\AdminComposer::class => 'admin.*',
            \App\Http\ViewComposers\MemberComposer::class => 'member.*',
            \App\Http\ViewComposers\PerformerComposer::class => 'performer.*',
        ]);
    }
}
