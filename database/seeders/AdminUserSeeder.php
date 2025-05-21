<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Certifique-se de que o namespace do seu modelo User está correto
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            [
                'email' => 'erickson.mauricio@gimb.com.br', // E-mail do usuário principal/admin
            ],
            [
                'name' => 'Administrador Principal',    // Nome do usuário
                'password' => Hash::make('er1ck5523'), // Defina uma senha forte!
                // Adicione aqui outros campos necessários para o seu modelo User, se houver
                // 'email_verified_at' => now(), // Se você quiser que o email já venha verificado
            ]
        );

        // Você pode adicionar mais usuários aqui se desejar
        // User::firstOrCreate(
        //     ['email' => 'outro_usuario@example.com'],
        //     [
        //         'name' => 'Outro Usuário',
        //         'password' => Hash::make('outraSenha123'),
        //     ]
        // );

        $this->command->info('Usuário administrador principal criado/verificado com sucesso!');
    }
}