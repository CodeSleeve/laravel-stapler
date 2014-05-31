<?php namespace Codesleeve\LaravelStapler\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Codesleeve\LaravelStapler\Services\ImageRefreshService;

class RefreshCommand extends Command
{
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'stapler:refresh';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Regenerate images for a given model (and optional attachment and styles)';

	/**
	 * The image refresh service that will be used to
	 * rebuild images.
	 *
	 * @var ImageRefreshService
	 */
	protected $imageRefreshService;

	/**
	 * Create a new command instance.
	 *
	 * @param  ImageRefreshService $imageRefreshService
	 * @return void
	 */
	public function __construct(ImageRefreshService $imageRefreshService)
	{
		parent::__construct();

		$this->imageRefreshService = $imageRefreshService;
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$this->info('Refreshing uploaded images...');
		$this->imageRefreshService->refresh($this->argument('class'), $this->option('attachments'));
		$this->info('Done!');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('class', InputArgument::REQUIRED, 'The name of a class (model) to refresh images on'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('attachments', null, InputOption::VALUE_OPTIONAL, 'A list of specific attachments to refresh images on.'),
		);
	}
}
