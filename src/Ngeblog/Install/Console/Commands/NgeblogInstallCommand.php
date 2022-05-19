<?php

namespace Ngeblog\Install\Console\Commands;

use Ngeblog\User\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;

class NgeblogInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ngeblog:install 
                            {server=development : The environment server}';
 
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the ngeblog app';
 
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
 
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (! in_array($this->argument('server'), ['production', 'development'])) {
            throw new InvalidArgumentException('Invalid server.');
        }

        $this->copyAppJs();
        $this->copyAppScss();
        $this->copyPackageJson();
        $this->copyPackageLockJson();
        $this->copyWEbpackMixJs();
        $this->copyTailwindConfigJs();
        $this->copyConfig();
        $this->copyRoutes();

        if ($this->argument('server') === 'development') {

            $this->migrate();
            $this->seed();

        } elseif($this->argument('server') === 'production') {

            $this->migrate();
            $this->promptCreateUser();

        }

        $this->info('The ngeblog installed successfully.');
        $this->comment('Please run "npm install && npm run dev or npm run production" to compleate the installation.');
    }

    public function copyPackageJson()
    {
        $this->info('Copy package.json');
        copy(__DIR__ . '/../../stubs/package.json', base_path('package.json'));
    }

    public function copyPackageLockJson()
    {
        $this->info('Copy package-lock.json');
        copy(__DIR__ . '/../../stubs/package-lock.json', base_path('package-lock.json'));
    }

    public function copyWebpackMixJs()
    {
        $this->info('Copy webpack.mix.js');
        copy(__DIR__ . '/../../stubs/webpack.mix.js', base_path('webpack.mix.js'));
    }

    public function copyTailwindConfigJs()
    {
        $this->info('Copy tailwind.config.js');
        copy(__DIR__ . '/../../stubs/tailwind.config.js', base_path('tailwind.config.js'));
    }

    public function copyAppJs()
    {
        if (!File::exists(resource_path('js'))) {
            File::makeDirectory(resource_path('js'), 0755, true, true);
        }

        $this->info('Copy app.js');

        copy(__DIR__ . '/../../stubs/resources/js/app.js', resource_path('js/app.js'));
    }

    public function copyAppScss()
    {
        if (!File::exists(resource_path('sass'))) {
            File::makeDirectory(resource_path('sass'), 0755, true, true);
        }

        $this->info('Copy app.scss');
        
        copy(__DIR__ . '/../../stubs/resources/sass/app.scss', resource_path('sass/app.scss'));
    }

    public function copyConfig()
    {
        $this->info('Copy config');
        copy(__DIR__ . '/../../../../../config/auth.php', config_path('auth.php'));
        copy(__DIR__ . '/../../../../../config/comment.php', config_path('comment.php'));
    }

    public function copyRoutes()
    {
        $this->info('Copy web.php');
        copy(__DIR__ . '/../../stubs/routes/web.php', base_path('routes/web.php'));
    }

    public function migrate()
    {
        $this->info('Migrating the database');
        Artisan::call('migrate:fresh');
    }

    public function seed()
    {
        $this->info('Seeding the database');
        Artisan::call('db:seed', [
            '--class' => 'Ngeblog\Database\Seeders\AppSeeder',
        ]);
    }

    public function promptCreateUser()
    {
        $name = $this->ask('What is your name?');
        $email = $this->ask('What is your email?');
        $password = $this->secret('What is your password?');

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);
    }
}
