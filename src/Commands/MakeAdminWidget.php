<?php


namespace DenisKisel\LaravelAdminWidget\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

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
        $stub = str_replace('{code}', $this->argument('code'), $stub);
        $stub = str_replace('{name}', $this->name(), $stub);

        File::put($this->filePath(), $stub);
        $this->makeRoute();
    }

    protected function className()
    {
        $nameParts = $this->nameParts();

        $output = '';
        foreach ($nameParts as $namePart) {
            $output .= ucfirst($namePart);
        }
        return $output . 'Widget';
    }

    protected function name()
    {
        $nameParts = $this->nameParts();

        $output = '';
        foreach ($nameParts as $namePart) {
            $output .= ucfirst($namePart) . ' ';
        }

        return substr($output, 0, -1);
    }

    protected function filePath()
    {
        return $this->widgetsPath() . $this->className() . '.php';
    }

    protected function widgetsPath()
    {
        return __DIR__ . '/../../../../../app/Admin/Controllers/Widgets/';
    }

    protected function nameParts()
    {
        return explode('_', $this->argument('code'));
    }

    protected function makeRoute()
    {
        $routeName = str_replace('_', '-', $this->argument('code')) . '-widget';
        $content = file_get_contents(__DIR__ . '/../../../../../app/Admin/routes.php');

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
        file_put_contents(__DIR__ . '/../../../../../app/Admin/routes.php', $content);

        $this->info('Route added: admin/' . $routeName);

    }

    protected function isExists()
    {
        return File::exists($this->filePath());
    }
}
