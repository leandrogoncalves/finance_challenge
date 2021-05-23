<?php

namespace App\Providers;

use App\Repositories\BalanceRepository;
use App\Repositories\Contracts\BalanceRepositoryInterface;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use App\Services\Contracts\TransactionServiceInterface;
use App\Services\TransactionService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);
        $this->app->bind(BalanceRepositoryInterface::class, BalanceRepository::class);
        $this->app->bind(TransactionServiceInterface::class, TransactionService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
