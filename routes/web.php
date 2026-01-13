<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\FormateurCrud;
use App\Livewire\FormationCrud;
use App\Livewire\EtudiantCrud;
use App\Livewire\InscriptionCrud;
use App\Livewire\DonsCrud;
use App\Livewire\Front\Index;




Route::get('/', function () {
    return redirect('acceuil');
});

// routes all front
 Route::get('/acceuil', Index::class)
        ->name('acceuil');




// routes all backend
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
   Route::get('/dashboard', Dashboard::class)
        ->name('dashboard');

Route::get('/formateur' , FormateurCrud::class)
    ->name('formateur');

Route::get('/formation' , FormationCrud::class)
    ->name('formation');

Route::get('/etudiant' , EtudiantCrud::class)
    ->name('etudiant');


Route::get('/inscritption' , InscriptionCrud::class)
    ->name('inscription');

Route::get('/dons' , DonsCrud::class)
    ->name('dons');

});

