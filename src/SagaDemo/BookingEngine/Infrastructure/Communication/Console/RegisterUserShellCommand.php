<?php

declare(strict_types=1);

namespace SagaDemo\BookingEngine\Infrastructure\Communication\Console;

use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RegisterUserShellCommand extends Command
{
    private OutputInterface $output;
    private InputInterface $input;

    public function __construct(private Connection $connection)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('saga:user:register')
            ->setDescription('Register new user')
            ->setDefinition([
                new InputArgument('name', InputArgument::REQUIRED, 'User name'),
                new InputArgument('surname', InputArgument::REQUIRED, 'User surname'),
                new InputArgument('email', InputArgument::REQUIRED, 'User email'),
                new InputArgument('age', InputArgument::OPTIONAL, 'User age', 36),
                new InputArgument('height', InputArgument::OPTIONAL, 'User height', 1.75),
                new InputArgument('characteristics', InputArgument::OPTIONAL, 'User characteristics', ['blond', 'skinny']),
            ]);
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        parent::initialize($input, $output);

        $this->output = $output;
        $this->input = $input;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $schemaManager = $this->connection->createSchemaManager();

        $table = $schemaManager->introspectSchema()->createTable('saga_state');

        $table->addColumn('id', 'guid', ['length' => 36]);
        $table->addColumn('done', 'boolean', ['default' => false]);
        $table->addColumn('sagaId', 'string');
        $table->setPrimaryKey(['id']);

        $schemaManager->createTable($table);
    }
}
