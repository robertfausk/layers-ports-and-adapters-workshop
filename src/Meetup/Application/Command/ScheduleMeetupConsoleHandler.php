<?php
declare(strict_types=1);

namespace Meetup\ApplicationCommand;

use Meetup\Domain\Entity\Description;
use Meetup\Domain\Entity\Meetup;
use Meetup\Domain\Entity\MeetupRepository;
use Meetup\Domain\Entity\Name;
use Meetup\Domain\Entity\ScheduledDate;
use Webmozart\Console\Api\Args\Args;
use Webmozart\Console\Api\IO\IO;

final class ScheduleMeetupConsoleHandler
{
    /**
     * @var MeetupRepository
     */
    private $repository;

    public function __construct(MeetupRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(Args $args, IO $io): int
    {
        $meetup = Meetup::schedule(
            Name::fromString($args->getArgument('name')),
            Description::fromString($args->getArgument('description')),
            ScheduledDate::fromPhpDateString($args->getArgument('scheduledFor'))
        );
        $this->repository->add($meetup);

        $io->writeLine('<success>Scheduled the meetup successfully</success>');

        return 0;
    }
}
