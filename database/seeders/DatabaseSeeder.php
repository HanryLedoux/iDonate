<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Feedback;
use App\Models\FoodItem;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a few users with roles (avoid duplicates)
        $donor = User::firstOrCreate(
            ['email' => 'doador@example.com'],
            ['name' => 'Empresa Exemplo', 'role' => 'doador', 'password' => bcrypt('password')]
        );

        $volunteer = User::firstOrCreate(
            ['email' => 'voluntario@example.com'],
            ['name' => 'Voluntario Exemplo', 'role' => 'voluntario', 'password' => bcrypt('password')]
        );

        $receiver = User::firstOrCreate(
            ['email' => 'receptor@example.com'],
            ['name' => 'Receptor Exemplo', 'role' => 'receptor', 'password' => bcrypt('password')]
        );

        // Create company for donor
        $company = Company::create([
            'user_id' => $donor->id,
            'name' => 'Acme Alimentos',
            'location' => 'São Paulo, SP',
            'description' => 'Empresa parceira que doa alimentos excedentes.',
        ]);

        // Create some food items
        $soup = FoodItem::firstOrCreate([
            'company_id' => $company->id,
            'title' => 'Sopa caseira'
        ],[
            'description' => 'Porções prontas para distribuição',
            'quantity' => 50,
            'is_available' => true,
        ]);

        $sandwich = FoodItem::firstOrCreate([
            'company_id' => $company->id,
            'title' => 'Sanduíche'
        ],[
            'description' => 'Sanduíches embalados individualmente',
            'quantity' => 120,
            'is_available' => true,
        ]);

        // Create an event
        $event = Event::create([
            'user_id' => $donor->id,
            'title' => 'Campanha Solidária Central',
            'description' => 'Arrecadação e distribuição de refeições para famílias locais.',
            'event_date' => now()->addDays(7),
            'location' => 'Praça Central',
        ]);

        // Register volunteer to event
        EventRegistration::create([
            'event_id' => $event->id,
            'user_id' => $volunteer->id,
        ]);

        // Create a donation reserved by receiver
        Donation::create([
            'food_item_id' => $soup->id,
            'user_id' => $receiver->id,
            'status' => 'pending',
        ]);

        // Add feedback
        Feedback::create([
            'user_id' => $volunteer->id,
            'type' => 'sugestao',
            'message' => 'Ótima iniciativa, seria bom ter filtros por localização.',
        ]);

        // Additional sample users
        User::factory(5)->create();

        // Additional companies
        $company2 = Company::firstOrCreate(['name' => 'Hanry'], ['user_id' => $volunteer->id, 'location' => 'Rio de Janeiro, RJ', 'description' => 'Parceiro iDonate']);
        $company3 = Company::firstOrCreate(['name' => 'Solidariza'], ['user_id' => $donor->id, 'location' => 'Belo Horizonte, MG', 'description' => 'Rede de doações local']);

        // Add 16 food items across companies
        for ($i = 1; $i <= 16; $i++) {
            $cmp = ($i % 3 === 0) ? $company2 : (($i % 2 === 0) ? $company3 : $company);
            FoodItem::firstOrCreate([
                'company_id' => $cmp->id,
                'title' => "Alimento Exemplo {$i}"
            ],[
                'description' => 'Porção doada',
                'quantity' => rand(5, 200),
                'is_available' => true,
            ]);
        }

        // Add 8 events
        for ($e = 1; $e <= 8; $e++) {
            Event::firstOrCreate([
                'title' => "Evento Solidário {$e}",
            ],[
                'user_id' => ($e % 2 === 0) ? $donor->id : $volunteer->id,
                'description' => 'Evento para arrecadação e distribuição de alimentos.',
                'event_date' => now()->addDays(3 * $e),
                'location' => 'Local de Ação'
            ]);
        }
    }
}
