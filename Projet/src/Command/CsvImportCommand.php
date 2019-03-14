<?php

namespace App\Command;

use League\Csv\Reader;
use App\Entity\Recette;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CsvImportCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        parent::__construct();

        $this->manager = $manager;
    }

    protected function configure()
    {
        $this  
            ->setName('csv:import')
            ->setDescription('Importe un fichier CSV')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Tentative d\'importation ...');

        // $recette->setNom('Fromage au pates');
        // $recette->setImage('une très belle photo');
        // $recette->setDescription('Mettez tout d\'abord le fromage, puis les pates, et c\'est parti');
        // $recette->setKcal(2345);
        // $recette->setTempsPrep(20);
        // $recette->setTypeRepas('Dejeuner/dinner');
        // $recette->setCategorieRepas('Vegan');
        // $recette->setDifficulte('Facile');

        $reader = Reader::createFromPath('%kernel.root_dir%/../src/Data/Recette.csv');

        $results = $reader->fetchAssoc();

        foreach ($results as $row){

            $kcal = rand(300, 1200);
            $recette = (new Recette())
                ->setNom($row['nom'])
                ->setImage($row['image'])
                ->setDescription($row['description'])
                ->setKcal($kcal)
                ->setTempsPrep($row['temps'])
                ->setTypeRepas($row['type'])
                ->setTags($row['tags'])
                ->setDifficulte($row['difficulte'])
            ;
            $this->manager->persist($recette);
        }

        $this->manager->flush();

        $io->success('Tout s\'est bien passé !');
    }
}
