<?php

namespace App\Console\Commands;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdministratorUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-administrator-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an administrator user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Crear un usuario administrador');

        $name = $this->ask('Ingrese el nombre del usuario administrador');
        while (empty($name) || strlen($name) > 255) {
            $this->error('El nombre del usuario es requerido y no puede superar los 255 caracteres');
            $name = $this->ask('Ingrese el nombre del usuario administrador');
        }

        $email = $this->ask('Ingrese el correo electrónico del usuario administrador');
        while (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('El correo electrónico es requerido y debe ser válido');
            $email = $this->ask('Ingrese el correo electrónico del usuario administrador');
        }

        // Check if the email already exists
        if (User::where('email', $email)->exists()) {
            $this->error('El correo electrónico ya está en uso');
            return;
        }

        $password = $this->secret('Ingrese la contraseña del usuario administrador');
        while (empty($password) || strlen($password) < 8) {
            $this->error('La contraseña es requerida y debe tener al menos 8 caracteres');
            $password = $this->secret('Ingrese la contraseña del usuario administrador');
        }

        // Progress bar
        $bar = $this->output->createProgressBar(5);
        $bar->setFormat('Creando usuario... %current%/%max% [%bar%] %percent%');
        $bar->setMessage('Creando usuario...');

        // Emulate some work
        for ($i = 0; $i < 5; $i++) {
            $bar->advance();
            usleep(500000); // 500ms
        }

        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            $user->roles()->attach(Role::ADMINISTRATOR->value);
        } catch (\Throwable $th) {
            $this->error('Error al crear el usuario administrador');
            return;
        }

        $bar->finish();
        $this->info('Usuario administrador creado correctamente');
    }
}
