<?php
namespace DenisKisel\LaravelAdminWidget\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

Class FixGetKeyNestedForm extends Command
{
    protected $signature = 'fix:nested_form';

    public function handle()
    {
        $nestedFormPath = base_path('vendor/encore/laravel-admin/src/Form/NestedForm.php');
        $content = File::get($nestedFormPath);
        $content = str_replace('if ($this->model) {', 'if ($this->model && method_exists($this->model, \'getKey\')) {', $content);
        File::put($nestedFormPath, $content);

        $this->info('Nested Form Is Fixed!');
    }
}
