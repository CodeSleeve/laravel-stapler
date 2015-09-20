<?php

namespace Codesleeve\LaravelStapler\Services;

use Codesleeve\LaravelStapler\Exceptions\InvalidClassException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;

class ImageRefreshService
{
    /**
     * The laravel application instance.
     *
     * @var Application
     */
    protected $app;

    /**
     * A Symfony console output instance.
     *
     * @var OutputInterface
     */
    protected $output;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @param OutputInterface $output
     */
    public function setOutput(OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * Attempt to refresh the defined attachments on a particular model.
     *
     * @throws InvalidClassException
     *
     * @param string $class
     * @param string $attachments
     */
    public function refresh($class, $attachments)
    {
        if (!method_exists($class, 'hasAttachedFile')) {
            throw new InvalidClassException("Invalid class: the $class class is not currently using Stapler.", 1);
        }

        $models = $this->app->make($class)->all();

        if ($attachments) {
            $attachments = explode(',', str_replace(', ', ',', $attachments));
            $this->processSomeAttachments($models, $attachments);
        } else {
            $this->processAllAttachments($models);
        }
    }

    /**
     * Process a only a specified subset of stapler attachments.
     *
     * @param Collection $models
     * @param array      $attachments
     */
    protected function processSomeAttachments(Collection $models, array $attachments)
    {
        $progress = $this->getProgressBar($models);
        $progress->start();

        foreach ($models as $model) {
            $progress->advance();

            foreach ($model->getAttachedFiles() as $attachedFile) {
                if (in_array($attachedFile->name, $attachments)) {
                    $attachedFile->reprocess();
                }
            }
        }

        $progress->finish();
    }

    /**
     * Process all stapler attachments defined on a class.
     *
     * @param Collection $models
     */
    protected function processAllAttachments(Collection $models)
    {
        $progress = $this->getProgressBar($models);
        $progress->start();

        foreach ($models as $model) {
            $progress->advance();

            foreach ($model->getAttachedFiles() as $attachedFile) {
                $attachedFile->reprocess();
            }
        }

        $progress->finish();
    }

    /**
     * Get an instance of the ProgressBar helper.
     *
     * @param Collection $models
     *
     * @return ProgressBar
     */
    protected function getProgressBar(Collection $models)
    {
        $output = $this->output ?: new NullOutput();
        $progress = new ProgressBar($output, $models->count());

        return $progress;
    }
}
