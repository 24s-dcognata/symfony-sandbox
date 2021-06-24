<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Lock\LockFactory;
use Symfony\Component\Lock\Store\SemaphoreStore;

class LockedCommand extends Command
{
    protected static $defaultName = 'app:locked-command';
    protected static $defaultDescription = 'Use example of Lock-Component';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $store = new SemaphoreStore();
        $factory = new LockFactory($store);

        $lock = $factory->createLock('command-locker', 3.0);
        if (!$lock->acquire()) {
            return Command::FAILURE;
        }
        try {
            sleep(10);
        } finally {
            $lock->release();
        }

        return Command::SUCCESS;
    }
}
