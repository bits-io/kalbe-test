<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->seedOutlets();
        $this->seedSalesmen();
        $this->seedUserRegions();
        $this->seedSalesTransactions();
    }

    private function seedOutlets()
    {
        $regions = ['North', 'South', 'East', 'West'];
        $outlets = [];

        for ($i = 1; $i <= 100; $i++) {
            $outlets[] = [
                'OutletName' => 'Outlet ' . $i,
                'Region' => $regions[array_rand($regions)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('outlets')->insert($outlets);
    }

    private function seedSalesmen()
    {
        $salesmen = [];

        for ($i = 1; $i <= 100; $i++) {
            $salesmen[] = [
                'SalesmanName' => 'Salesman ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('salesmen')->insert($salesmen);
    }

    private function seedUserRegions()
    {
        $regions = ['North', 'South', 'East', 'West'];
        $userRegions = [];

        for ($i = 1; $i <= 100; $i++) {
            $userRegions[] = [
                'UserID' => $i,
                'Region' => $regions[array_rand($regions)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('user_regions')->insert($userRegions);
    }

    private function seedSalesTransactions()
    {
        $transactions = [];
        $startDate = '2025-01-01';
        $endDate = '2025-01-31';

        for ($i = 1; $i <= 100; $i++) {
            $transactions[] = [
                'OutletID' => rand(1, 100),
                'SalesmanID' => rand(1, 100),
                'TransactionDate' => date('Y-m-d', strtotime("+$i day", strtotime($startDate))),
                'Subtotal' => rand(1000, 10000) * 1.23, // Random subtotal
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (strtotime("+$i day", strtotime($startDate)) > strtotime($endDate)) {
                break;
            }
        }

        DB::table('sales_transactions')->insert($transactions);
    }
}
