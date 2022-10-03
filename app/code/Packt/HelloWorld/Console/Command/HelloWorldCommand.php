<?php
namespace Packt\HelloWorld\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;


class HelloWorldCommand extends Command
{
    const INPUT_KEY_EXTENDED = 'extended';
    protected function configure()
    {
        $options = [
            new InputOption(
                self::INPUT_KEY_EXTENDED,
                null,
                InputOption::VALUE_NONE,
                'Get extended info'
            ),
        ];
        $this->setName('helloworld:info')
            ->setDescription('Get info about installation')
            ->setDefinition($options);
        parent::configure();
    }
    protected function execute(InputInterface $input,
                               OutputInterface $output)
    {
        $output->writeln('<error>' . 'writeln surrounded by error tag' . '</error>');
        $output->writeln('<comment>' . 'writeln surrounded by comment tag' . '</comment>');
        $output->writeln('<info>' . 'writeln surrounded by info tag' . '</info>');
        $output->writeln('<question>' . 'writeln surrounded by question tag' . '</question>');
        $output->writeln('writeln with normal output');
        if ($input->getOption(self::INPUT_KEY_EXTENDED)) {
            $output->writeln('');
            $output->writeln('<info>'.'Extended parameter is given'.'</info>');
        }
        $output->writeln('');
    }
}
