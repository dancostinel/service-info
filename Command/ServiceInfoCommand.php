<?php
namespace DanCostinel\ServiceInfoBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ServiceInfoCommand extends ContainerAwareCommand {
    protected function configure()     {
        $this
            ->setName('service:get:methods')
            ->setDescription('Get all methods available for a provided service id')
	          ->addArgument('service-id', InputArgument::REQUIRED, 'Enter a service id')
            ->addOption(
                'methods',
                'm',
                InputOption::VALUE_REQUIRED,
                'Print only the methods names',
                null
            )
       ;
    }
    protected function execute(InputInterface $input, OutputInterface $output){
	      if(!$this->getContainer()->has($input->getArgument('service-id'))){
            throw new \Exception('The service id you\'ve provided does not exist! You may want to use debug:container console command to get a valid service id.');
        }

        $serviceId = $this->getContainer()->get($input->getArgument('service-id'));//eg. logger
        $serviceIdClass = get_class($serviceId); //Symfony\Bridge\Monolog\Logger
        $reflectionClass = new \ReflectionClass($serviceIdClass); // Symfony\Bridge\Monolog\Logger
        $reflectionClassName = $reflectionClass->getShortName();  // Logger

        $serviceClassName = new \ReflectionClass($serviceIdClass);
        $serviceClassMethods = $serviceClassName->getMethods(); //gets all Logger class methods
        if($input->getOption('methods') == true){ // if --methods=true||-m=true ...
            $output->writeln(var_dump($serviceClassMethods));// ...print only methods...
        } else if(null === $input->getOption('methods')){ // ...else...
            $output->writeln(var_dump($reflectionClass->__toString()));// ...print whole class info
        }
    }
}
