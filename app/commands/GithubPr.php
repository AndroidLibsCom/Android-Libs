<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use \GrahamCampbell\GitHub\Facades\GitHub;

class GithubPr extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'github:pr';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate pull requests for all libs';

	/**
	 * Create a new command instance.
	 *
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
		set_time_limit(0);
		$this->comment('Generating Pull Requests for all libraries..');
		$oLibs = Libraries::where('url', '!=', 'https://github.com/sephiroth74/ViewRevealAnimator')
			->where('url', '!=', 'https://github.com/JakeWharton/kotterknife')
			->where('url', '!=', 'https://github.com/JakeWharton/butterknife')
			->get();
		$oGitHubLibs = [];
		foreach($oLibs as $oLib)
		{
			if($oLib->isGitHubUrl())
			{
				$oGitHubLibs[] = $oLib;
			}
		}

		$aCommiter = ['name' => 'AndroidLibs Shields', 'email' => 'info@android-libs.com'];

		foreach($oGitHubLibs as $oLib)
		{
			$this->info('Generating Fork for ' . $oLib->title);
			GitHub::connection('pr')->repo()->forks()->create($oLib->getGitHubUserName(), $oLib->getGitHubRepoName());
			sleep(3);
			$oldRepo = GitHub::connection('pr')->repo()->contents()->readme('AndroidLibsPR', $oLib->getGitHubRepoName());

			$sShield = '[![AndroidLibs](https://img.shields.io/badge/AndroidLibs-' . htmlentities(str_replace('-', '%20',$oLib->title)) . '-brightgreen.svg?style=flat)](' . url('/lib/' . $oLib->slug . '?utm_source=github-badge&utm_medium=github-badge&utm_campaign=github-badge', [], true) . ')
			';

			$sNewContent = $sShield . base64_decode($oldRepo['content']);

			Github::connection('pr')->repo()->contents()->create('AndroidLibsPR', $oLib->getGitHubRepoName(), $oldRepo['path'], $sNewContent, 'Added AndroidLibs Shield', $oldRepo['sha'], 'master', $aCommiter);

			GitHub::connection('pr')->pullRequest()->create($oLib->getGitHubUserName(), $oLib->getGitHubRepoName(), [
				'base' 	=> 'master',
				'head' 	=> 'AndroidLibsPR:master',
				'title'	=> 'Added Shield',
				'body'	=> 'Added a shield.io badge for android-libs.com; a repository with hundreds of android libraries!'
			]);
			$this->info('ADDED!');
		}




		$this->info('DONE!');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
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

}
