<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Filesystem\Filesystem;

class MigrateCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'migrate:subfolder';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Run migrates for sub folder.';

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
	public function fire()
	{
		$parentFolder = app_path('database/migrations');
		$allFolder = scandir($parentFolder);

		$_fileService = new Filesystem();
		$_tmpPath     = app_path('storage') . DIRECTORY_SEPARATOR . 'migrations';

		if (!is_dir($_tmpPath) && !$_fileService->exists($_tmpPath))
		{
			$_fileService->mkdir($_tmpPath);
		}
	
		$this->info("Gathering migration files to {$_tmpPath}");

		if( !empty($allFolder) ){
			$_fileService->remove($_tmpPath);
			foreach( $allFolder as $folder ){
				if( is_dir($parentFolder.'/'.$folder) && $folder != '.' && $folder != '..'  ){
					$_fileService->mirror($parentFolder.'/'.$folder, $_tmpPath);
				}
			}
			$this->info("Migrating...");
			$this->call('migrate', array('--path' => ltrim(str_replace(base_path(), '', $_tmpPath), '/')));
			// Delete all temp migration files
			$this->info("Cleaning temporary files");
			$_fileService->remove($_tmpPath);

			// Done
			$this->info("DONE!");

		}

	}

	// /**
	//  * Get the console command arguments.
	//  *
	//  * @return array
	//  */
	// protected function getArguments()
	// {
	// 	return array(
	// 		array('example', InputArgument::REQUIRED, 'An example argument.'),
	// 	);
	// }

	// /**
	//  * Get the console command options.
	//  *
	//  * @return array
	//  */
	// protected function getOptions()
	// {
	// 	return array(
	// 		array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
	// 	);
	// }

}
