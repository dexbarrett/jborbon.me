<?php

namespace DexBarrett\Console\Commands;

use DexBarrett\User;
use Illuminate\Console\Command;

class CreateUser extends Command
{
    protected $user;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'createuser {username} {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = $this->user->where('username', $this->argument('username'))
                            ->orWhere('email', $this->argument('email'))->first();

        if (count($user)) {
            $this->error('ya existe un usuario con ese correo o username');
            return;
        }

        $newUser = $this->user->create([
            'username' => $this->argument('username'),
            'email' => $this->argument('email'),
            'password' => $this->argument('password')
        ]);

        $this->info('usuario creado');
    }
}
