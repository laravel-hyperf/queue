<?php

declare(strict_types=1);

namespace LaravelHyperf\Queue\Console;

use Hyperf\Command\Command;
use LaravelHyperf\Cache\Contracts\Factory as CacheFactory;
use LaravelHyperf\Support\Traits\HasLaravelStyleCommand;
use LaravelHyperf\Support\Traits\InteractsWithTime;

class RestartCommand extends Command
{
    use HasLaravelStyleCommand;
    use InteractsWithTime;

    /**
     * The console command name.
     */
    protected ?string $name = 'queue:restart';

    /**
     * The console command description.
     */
    protected string $description = 'Restart queue worker daemons after their current job';

    /**
     * Create a new queue restart command.
     */
    public function __construct(
        protected CacheFactory $cache
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /* @phpstan-ignore-next-line */
        $this->cache->forever('illuminate:queue:restart', $this->currentTime());

        $this->info('Broadcasting queue restart signal.');
    }
}
