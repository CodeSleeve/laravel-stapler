<?php namespace Codesleeve\LaravelStapler\Services;

use Codesleeve\LaravelStapler\Exceptions\InvalidClassException;
use Illuminate\Database\Eloquent\Collection;
use App;

class ImageRefreshService
{
	/**
	 * Attempt to refresh the defined attachments on a particular model.
	 *
     * @throws InvalidClassException
	 * @param  string $class
	 * @param  array $attachments
	 * @return void
	 */
	public function refresh($class, array $attachments)
	{
		if (!method_exists($class, 'hasAttachedFile')) {
			throw new InvalidClassException("Invalid class: the $class class is not currently using Stapler.", 1);
		}

		$models = App::make($class)->all();

		if ($attachments)
		{
			$attachments = explode(',', str_replace(', ', ',', $attachments));
			$this->processSomeAttachments($models, $attachments);

			return;
		}

		$this->processAllAttachments($models);
	}

	/**
	 * Process a only a specified subset of stapler attachments.
	 *
	 * @param  Collection $models
	 * @param  array $attachments
	 * @return void
	 */
	protected  function processSomeAttachments(Collection $models, array $attachments)
	{
		foreach ($models as $model)
		{
			foreach ($model->getAttachedFiles() as $attachedFile)
			{
				if (in_array($attachedFile->name, $attachments)) {
					$attachedFile->reprocess();
				}
			}
		}
	}

	/**
	 * Process all stapler attachments defined on a class.
	 *
	 * @param  Collection $models
	 * @return void
	 */
	protected function processAllAttachments(Collection $models)
	{
		foreach ($models as $model)
		{
			foreach ($model->getAttachedFiles() as $attachedFile)
			{
				$attachedFile->reprocess();
			}
		}
	}
}