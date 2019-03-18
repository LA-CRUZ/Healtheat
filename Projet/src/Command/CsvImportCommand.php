<?php

namespace App\Command;

use League\Csv\Reader;
use App\Entity\Recette;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
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
            ->addOption(
                'recette',
                'r',
                InputOption::VALUE_NONE,
                'Importe les recettes'
            )
            ->addOption(
                'ingredient',
                'i',
                InputOption::VALUE_NONE,
                'Importe les ingredients'
            )
            ->addOption(
                'all',
                'a',
                InputOption::VALUE_NONE,
                'Importe tout'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        if($input->getOption('recette') == false and $input->getOption('ingredient') == false and $input->getOption('all') == false)
            $choix = $io->choice('Selectionnez le jeu de donnée à importer', ['recette', 'ingredient', 'all'], 'all');
        else
            $choix = '';

        if($input->getOption('recette') || $choix == 'recette'){

            $io->title('Importation des recettes');

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
        }
        if($input->getOption('ingredient') || $choix == 'ingredient'){

            $io->title('Importation des ingredients');

            $reader = Reader::createFromPath('%kernel.root_dir%/../src/Data/Recette.csv');

            $results = $reader->fetchAssoc();

            foreach ($results as $row){

                // $kcal = rand(300, 1200);
                // $recette = (new Recette())
                //     ->setNom($row['nom'])
                //     ->setImage($row['image'])
                //     ->setDescription($row['description'])
                //     ->setKcal($kcal)
                //     ->setTempsPrep($row['temps'])
                //     ->setTypeRepas($row['type'])
                //     ->setTags($row['tags'])
                //     ->setDifficulte($row['difficulte'])
                // ;
                // $this->manager->persist($recette);
            }
        }
        if($input->getOption('all') || $choix == 'all'){

            $io->title('Importation des recettes et des ingredients');

            $reader = Reader::createFromPath('%kernel.root_dir%/../src/Data/Recette.csv');

            $results = $reader->fetchAssoc();

            foreach ($results as $row){

                // $kcal = rand(300, 1200);
                // $recette = (new Recette())
                //     ->setNom($row['nom'])
                //     ->setImage($row['image'])
                //     ->setDescription($row['description'])
                //     ->setKcal($kcal)
                //     ->setTempsPrep($row['temps'])
                //     ->setTypeRepas($row['type'])
                //     ->setTags($row['tags'])
                //     ->setDifficulte($row['difficulte'])
                // ;
                // $this->manager->persist($recette);
            }
        }

        $this->manager->flush();

        $io->success('Tout s\'est bien passé !');
    }
}
