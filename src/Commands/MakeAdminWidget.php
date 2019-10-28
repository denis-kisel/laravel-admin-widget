<?php


namespace DenisKisel\LaravelAdminWidget\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeAdminWidget extends Command
{
    protected $signature = 'admin:widget {code}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin widget';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->isExists()) {
            $this->warn('Widget with this code already exists!');
            die();
        }

        $stub = File::get(__DIR__ . '/stubs/widget.stub');

        $stub = str_replace('{class}', $this->className(), $stub);
        $stub = str_replace('{code}', Str::snake($this->argument('code')), $stub);
        $stub = str_replace('{name}', Str::title($this->argument('code')), $stub);

        File::put($this->filePath(), $stub);
        $this->makeRoute();
    }

    protected function className()
    {
        return Str::studly($this->argument('code')) . 'Widget';
    }

    protected function filePath()
    {
        return $this->widgetsPath() . $this->className() . '.php';
    }

    protected function widgetsPath()
    {
        return app_path('Admin/Controllers/Widgets/');
    }

    protected function makeRoute()
    {
        $routeName = Str::kebab($this->argument('code')) . '-widget';
        $content = file_get_contents(app_path('Admin/routes.php'));

        $replace = <<<EOF
    /*
    * Widget routes
    */
EOF;
        $replaceOn = <<<EOF
    /*
    * Widget routes
    */
    \$router->resource('{$routeName}', 'Widgets\\\\{$this->className()}');
EOF;
        $content = str_replace($replace, $replaceOn, $content);
        file_put_contents(app_path('Admin/routes.php'), $content);

        $this->info('Route added: admin/' . $routeName);

    }

    protected function isExists()
    {
        return File::exists($this->filePath());
    }
}
