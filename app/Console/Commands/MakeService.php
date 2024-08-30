<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;

class MakeService extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service { name }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create services success fully :)';

    /**
     * Execute the console command.
     */



    public function getStub()
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '/Stubs/service.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '/Services';
    }

    public function handle()
    {
        $name = $this->argument("name");
        $path = $this->getPath($name);

        if (file_exists($path)) {
            $this->error("Service {name} Already Exists");
            return;
        }
        parent::handle();
    }
}
