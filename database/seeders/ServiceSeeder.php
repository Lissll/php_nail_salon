<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Классический маникюр',
                'description' => 'Аккуратная обработка кутикулы, придание формы и покрытие базой',
                'duration' => 45,
                'price' => 900.00,
            ],
            [
                'name' => 'Аппаратный маникюр',
                'description' => 'Маникюр с использованием аппарата — бережно и быстро',
                'duration' => 60,
                'price' => 1200.00,
            ],
            [
                'name' => 'Маникюр + гель-лак',
                'description' => 'Стойкое покрытие гель-лаком любого оттенка',
                'duration' => 90,
                'price' => 1800.00,
            ],
            [
                'name' => 'Наращивание ногтей',
                'description' => 'Моделирование ногтей гелем любой длины и формы',
                'duration' => 150,
                'price' => 3000.00,
            ],
            [
                'name' => 'Педикюр',
                'description' => 'Комплексный аппаратный педикюр с уходом за стопами',
                'duration' => 90,
                'price' => 1600.00,
            ],
            [
                'name' => 'Дизайн ногтей',
                'description' => 'Художественная роспись, стразы, втирки, френч',
                'duration' => 30,
                'price' => 500.00,
            ],
            [
                'name' => 'SPA-уход для рук',
                'description' => 'Питательная маска, скраб и массаж рук',
                'duration' => 40,
                'price' => 800.00,
            ],
            [
                'name' => 'Снятие покрытия',
                'description' => 'Аккуратное снятие гель-лака без вреда для ногтей',
                'duration' => 30,
                'price' => 300.00,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}