<?php
namespace Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class HelloworldCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('yaf:helloworld')
            ->setDescription('Hello world demo')
            ->addArgument(
                'name',
                InputArgument::OPTIONAL,
                'Who do you want to say hello?'
            )
            ->addOption(
               'upper',
               null,
               InputOption::VALUE_NONE,
               'If set, the ouput will be in uppercase letters'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        if ($name) {
            $text = 'Hello '.$name;
        } else {
            $text = 'Hello';
        }

        if ($input->getOption('upper')) {
            $text = strtoupper($text);
        }

        $output->writeln($text);
    }
}