<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\LecturerDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\EnrollmentController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Dashboard route berdasarkan role
Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'lecturer') {
        return redirect()->route('lecturer.dashboard');
    } else {
        return redirect()->route('student.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    // Schedule Page (untuk semua user yang login)
    Route::get('/schedule', [\App\Http\Controllers\ScheduleController::class, 'index'])
        ->name('schedule.index');

    // 🔹 ROUTE KHUSUS STUDENT
    Route::middleware(['student'])->group(function () {
        Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])
            ->name('student.dashboard');
       
        Route::get('/enrollments', [EnrollmentController::class, 'index'])
            ->name('enrollments.index');
        Route::post('/enrollments/{courseId}/enroll', [EnrollmentController::class, 'enroll'])
            ->name('enrollments.enroll');
        Route::delete('/enrollments/{courseId}/drop', [EnrollmentController::class, 'drop'])
            ->name('enrollments.drop');
        
        // // Student juga bisa melihat bookings (read-only)
        // Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
        // Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    });

    // 🔹 ROUTE KHUSUS LECTURER
    Route::middleware(['lecturer'])->group(function () {
        Route::get('/lecturer/dashboard', [LecturerDashboardController::class, 'index'])
            ->name('lecturer.dashboard');

        // Dosen bisa CRUD bookings - gunakan prefix agar tidak bentrok
        Route::prefix('lecturer')->name('lecturer.')->group(function () {
            // Route resource lengkap
            Route::resource('bookings', BookingController::class);
        });
    });

    // 🔹 ROUTE KHUSUS ADMIN
    Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // CRUD hanya untuk admin
        Route::resource('labs', LabController::class);
        Route::resource('courses', CourseController::class);
        Route::resource('users', AdminUserController::class);

        // Booking management untuk admin
        Route::resource('bookings', AdminBookingController::class);
        Route::post('/bookings/{id}/approve', [AdminBookingController::class, 'approve'])
            ->name('bookings.approve');
        Route::post('/bookings/{id}/reject', [AdminBookingController::class, 'reject'])
            ->name('bookings.reject');
    });

    // Shared routes yang bisa diakses oleh multiple roles
    Route::middleware(['auth'])->group(function () {
        // Route yang bisa diakses oleh lecturer dan admin
        Route::middleware(['lecturer', 'admin'])->group(function () {
            // Tambahkan route yang bisa diakses oleh kedua role di sini
        });

        // Route yang bisa diakses oleh semua role yang sudah login
        Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
        Volt::route('settings/password', 'settings.password')->name('password.edit');
        Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');
        Volt::route('settings/two-factor', 'settings.two-factor')
            ->middleware(
                when(
                    Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                    ['password.confirm'],
                    [],
                ),
            )
            ->name('two-factor.show');
    });
});

require __DIR__ . '/auth.php';