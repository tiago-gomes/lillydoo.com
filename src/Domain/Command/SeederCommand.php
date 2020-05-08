<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 27/11/2018
 * Time: 12:45
 */

namespace App\Domain\Command;

use App\Domain\Seeder\InvoiceSeeder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Domain\Seeder\AccountSeeder;
use Psr\Container\ContainerInterface;

class SeederCommand extends Command
{
  /**
   * @var ContainerInterface
   */
  protected $container;
  
  /**
   * AccountSeeder constructor.
   * @param ContainerInterface $container
   * @throws \Exception
   */
  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
    parent::__construct();
  }
  
  protected function configure()
  {
    $this
      ->setName('seeder:db')
      ->setDescription('Seeds the database')
      ->setHelp('This command allows you to populate the database for development or testing proposes.')
    ;
  }
  
  /**
   * @param InputInterface $input
   * @param OutputInterface $output
   * @return int|null|void
   * @throws \Exception
   */
  protected function execute(InputInterface $input, OutputInterface $output)
  {
    try {
      // new AccountSeeder($this->container);
      new InvoiceSeeder($this->container);
    } catch(\Exception $e) {
      throw new \Exception($e->getMessage());
    }
  }
}