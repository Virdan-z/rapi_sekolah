<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;

// ADMIN
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ComplaintController;
use App\Http\Controllers\Admin\ReportController; // <-- Tambahan Controller Laporan

// PIC
use App\Http\Controllers\Pic\DashboardController as PicDashboardController;
use App\Http\Controllers\Pic\ComplaintController as PicComplaintController;
use App\Http\Controllers\Pic\EventController as PicEventController;

// GURU
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\EventController as GuruEventController;
use App\Http\Controllers\Guru\ComplaintController as GuruComplaintController;

// SISWA
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\EventController as SiswaEventController;

// TAMU / PUBLIC
use App\Http\Controllers\PublicAgendaController;


/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA
|--------------------------------------------------------------------------
*/

// Langsung memuat index PublicAgendaController pada root URL (tanpa redirect)
Route::get('/', [PublicAgendaController::class, 'index']);


/*
|--------------------------------------------------------------------------
| TAMU / PUBLIC
|--------------------------------------------------------------------------
|
| Tidak membutuhkan login.
| Tamu hanya dapat melihat agenda yang sudah disetujui.
|
*/

Route::get(
    '/agenda-publik',
    [PublicAgendaController::class, 'index']
)->name('public.agenda');


/*
|--------------------------------------------------------------------------
| ROUTE YANG MEMBUTUHKAN LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | ADMIN DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')
        ->get(
            '/dashboard',
            [DashboardController::class, 'index']
        )
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            

            Route::resource(
                'rooms',
                RoomController::class
            );

            Route::resource(
                'users',
                UserController::class
            );

            Route::resource(
                'events',
                EventController::class
            );

            Route::resource(
                'complaints',
                ComplaintController::class
            );

            // TAMBAHAN ROUTE LAPORAN ADMIN
            Route::get(
                'reports',
                [ReportController::class, 'index']
            )->name('reports.index');
        });


    /*
    |--------------------------------------------------------------------------
    | PIC
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:pic')
        ->prefix('pic')
        ->name('pic.')
        ->group(function () {

            Route::get(
                '/dashboard',
                [PicDashboardController::class, 'index']
            )->name('dashboard');


            // PIC COMPLAINTS

            Route::get(
                '/complaints',
                [PicComplaintController::class, 'index']
            )->name('complaints.index');

            Route::get(
                '/complaints/{complaint}',
                [PicComplaintController::class, 'show']
            )->name('complaints.show');

            Route::get(
                '/complaints/{complaint}/edit',
                [PicComplaintController::class, 'edit']
            )->name('complaints.edit');

            Route::put(
                '/complaints/{complaint}',
                [PicComplaintController::class, 'update']
            )->name('complaints.update');


            // PIC EVENTS

            Route::get(
                '/events',
                [PicEventController::class, 'index']
            )->name('events.index');

            Route::get(
                '/events/{event}',
                [PicEventController::class, 'show']
            )->name('events.show');

            Route::get(
                '/events/{event}/edit',
                [PicEventController::class, 'edit']
            )->name('events.edit');

            Route::put(
                '/events/{event}',
                [PicEventController::class, 'update']
            )->name('events.update');
        });


    /*
    |--------------------------------------------------------------------------
    | GURU
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:guru')
        ->prefix('guru')
        ->name('guru.')
        ->group(function () {

            Route::get(
                '/dashboard',
                [GuruDashboardController::class, 'index']
            )->name('dashboard');


            // GURU EVENTS

            Route::get(
                '/events',
                [GuruEventController::class, 'index']
            )->name('events.index');

            Route::get(
                '/events/create',
                [GuruEventController::class, 'create']
            )->name('events.create');

            Route::post(
                '/events',
                [GuruEventController::class, 'store']
            )->name('events.store');

            Route::get(
                '/events/{event}',
                [GuruEventController::class, 'show']
            )->name('events.show');


            // GURU COMPLAINTS

            Route::get(
                '/complaints',
                [GuruComplaintController::class, 'index']
            )->name('complaints.index');

            Route::get(
                '/complaints/create',
                [GuruComplaintController::class, 'create']
            )->name('complaints.create');

            Route::post(
                '/complaints',
                [GuruComplaintController::class, 'store']
            )->name('complaints.store');

            Route::get(
                '/complaints/{complaint}',
                [GuruComplaintController::class, 'show']
            )->name('complaints.show');
        });


    /*
    |--------------------------------------------------------------------------
    | SISWA
    |--------------------------------------------------------------------------
    |
    | Siswa hanya dapat melihat agenda yang sudah disetujui.
    | Tidak ada create, edit, update, atau delete.
    |
    */

    Route::middleware('role:siswa')
        ->prefix('siswa')
        ->name('siswa.')
        ->group(function () {

            // DASHBOARD SISWA

            Route::get(
                '/dashboard',
                [SiswaDashboardController::class, 'index']
            )->name('dashboard');


            // AGENDA SISWA

            Route::get(
                '/events',
                [SiswaEventController::class, 'index']
            )->name('events.index');

            Route::get(
                '/events/{event}',
                [SiswaEventController::class, 'show']
            )->name('events.show');
        });
});


/*
|--------------------------------------------------------------------------
| AUTH BREEZE
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';