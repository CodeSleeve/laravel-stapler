<?php

namespace Codesleeve\LaravelStapler\Services;

use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\LaravelStapler\Exceptions\InvalidClassException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Symfony\Component\Console\{Helper\ProgressBar, Output\NullOutput, OutputInterface};

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
     * @param Application     $app
     * @param OutputInterface $output
     */
    public function __construct(Application $app, OutputInterface $output = null)
    {
        $this->app = $app;
        $this->output = $output ?: new NullOutput();
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
     * @param string $className
     * @param string $attachments
     */
    public function refresh(string $className, string $attachments)
    {
        $model = $this->app->make($className);

        if (!$model instanceof StaplerableInterface) {
            throw new InvalidClassException("Invalid class: the $className class is not currently using Stapler.", 1);
        }

        if ($attachments) {
            $attachments = explode(',', str_replace(', ', ',', $attachments));
            $this->processSomeAttachments($model, $attachments);
        } else {
            $this->processAllAttachments($model);
        }
    }

    /**
     * Process a only a specified subset of stapler attachments.
     *
     * @param StaplerableInterface $model
     * @param array                $attachments
     */
    protected function processSomeAttachments(StaplerableInterface $model, array $attachments)
    {
        $progress = $this->getProgressBar($model->count());
        $progress->start();

        $model->chunk(100, function($models) use ($progress, $attachments) {
            $progress->advance();

            foreach ($models as $model) {
                foreach ($model->getAttachments() as $attachment) {
                    if (in_array($attachment->name, $attachments)) {
                        $attachment->reprocess();
                    }
                }
            }
        });

        $progress->finish();
    }

    /**
     * Process all stapler attachments defined on a class.
     *
     * @param StaplerableInterface $model
     */
    protected function processAllAttachments(StaplerableInterface $model)
    {
        $progress = $this->getProgressBar($model->count());
        $progress->start();

        $model->chunk(100, function($models) use ($progress) {
            $progress->advance();

            foreach ($models as $model) {
                foreach ($model->getAttachements() as $attachment) {
                    $attachment->reprocess();
                }
            }
        });

        $progress->finish();
    }

    /**
     * Get an instance of the ProgressBar helper.
     *
     * @param int $count
     *
     * @return ProgressBar
     */
    protected function getProgressBar(int $count)
    {
        $progress = new ProgressBar($this->output, $count);

        return $progress;
    }
}
