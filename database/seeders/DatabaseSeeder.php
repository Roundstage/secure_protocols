<?php

namespace Database\Seeders;

use App\Models\Protocol;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //User::factory(10)->create();


        Role::factory()->create([
            'name' => 'Gerente de TI',
            'description'=> 'O gerente de TI (Tecnologia da Informação) é responsável por coordenar e supervisionar todas as atividades relacionadas à tecnologia dentro de uma organização. Suas principais responsabilidades incluem:
Planejamento Estratégico: Desenvolver e implementar estratégias de tecnologia alinhadas com os objetivos da organização.
Gestão de Equipe: Liderar equipes de desenvolvedores, técnicos de suporte, analistas e outros profissionais de TI.
Orçamento e Controle de Custos: Gerenciar o orçamento de TI, buscando eficiência e controlando gastos.',
            'level' =>'Manager'
        ]);
        Role::factory()->create([
            'name'=> 'Programador',
            'description' => 'Um programador é um profissional que escreve, testa e mantém códigos de computador para criar software e aplicativos. Seu trabalho envolve:
                                Análise de Requisitos: Entender as necessidades dos usuários e clientes.
                                Desenvolvimento de Software: Escrever código utilizando linguagens de programação como PHP, JavaScript, Python, etc.
                                Testes e Debugging: Identificar e corrigir erros no código.',
            'level' =>'Staff'
        ]);
        Protocol::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'role_id' => 1,
        ]);
        User::factory()->create([
            'name' => 'Test Programador',
            'email' => 'Programador@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'role_id' => 2,
        ]);
    }
}
