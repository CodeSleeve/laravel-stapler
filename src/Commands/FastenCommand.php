<?php

namespace Codesleeve\LaravelStapler\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\View\Factory as View;
use Illuminate\Filesystem\Filesystem as File;
use Symfony\Component\Console\Input\InputArgument;

class FastenCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'stapler:fasten';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a migration for adding stapler file fields to a database table';

    /**
     * An instance of Laravel's view factory.
     * 
     * @var View
     */
    protected $view;

    /**
     * An instance of Laravel's filesystem.
     * 
     * @var File
     */
    protected $file;

    /**
     * The path to the application's migrations folder.
     * 
     * @var File
     */
    protected $migrationsFolderPath;

    /**
     * Create a new command instance.
     * 
     * @param View   $view
     * @param File   $file
     * @param string $migrationsFolderPath
     */
    public function __construct(View $view, File $file, $migrationsFolderPath)
    {
        parent::__construct();

        $this->view = $view;
        $this->file = $file;
        $this->migrationsFolderPath = $migrationsFolderPath;
    }

    /**
     * Execute the console command.
     */
    public function fire()
    {
        $this->createMigration();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['table', InputArgument::REQUIRED, 'The name of the database table the file fields will be added to.'],
            ['attachment', InputArgument::REQUIRED, 'The name of the corresponding stapler attachment.'],
            ['after', InputArgument::OPTIONAL, 'Name of a database field after which the file fields will get added.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array();
    }

    /**
     * Create a new migration.
     */
    protected function createMigration()
    {
        $data = ['table' => $this->argument('table'), 'attachment' => $this->argument('attachment'), 'after' => $this->argument('after')];
        $prefix = date('Y_m_d_His');

        $fileName = $this->migrationsFolderPath.'/'.$prefix.'_add_'.$data['attachment'].'_fields_to_'.$data['table'].'_table.php';
        $data['className'] = 'Add'.ucfirst(Str::camel($data['attachment'])).'FieldsTo'.ucfirst(Str::camel($data['table'])).'Table';

        // Save the new migration to disk using the stapler migration view.
        $migration = $this->view->make('laravel-stapler::migration', $data)->render();
        $this->file->put($fileName, $migration);

        // Dump the autoloader and print a created migration message to the console.
        $this->info("Created migration: $fileName");
    }
}
