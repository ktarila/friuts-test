<?php

/*
 * Frutits Test App.
 * (c) Patrick <ktarila@gmail.com>.
 */

namespace App\Command;

use App\Entity\Fruit;
use App\Entity\Nutrition;
use App\Repository\FruitRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'fruits:fetch',
    description: 'Fetch Fruits from API',
)]
class FruitsFetchCommand extends Command
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private FruitRepository $fruitRepository,
        private ValidatorInterface $validator,
        private MailerInterface $mailer
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $fruits = $this->fetchFruits();
        foreach ($fruits as $fruit) {
            $fruitEntity = new Fruit();
            $nutrition = new Nutrition();
            $nutrition->setCalories($fruit['nutritions']['calories'])
                ->setFat($fruit['nutritions']['fat'])
                ->setSugar($fruit['nutritions']['sugar'])
                ->setCarbohydrates($fruit['nutritions']['carbohydrates'])
                ->setProtein($fruit['nutritions']['protein']);
            $fruitEntity->setName($fruit['name'])
                ->setFamily($fruit['family'])
                ->setFruitOrder($fruit['order'])
                ->setGenus($fruit['genus'])
                ->setNutritions($nutrition);

            $errors = $this->validator->validate($fruitEntity);
            if (0 === $errors->count()) {
                $this->fruitRepository->save($fruitEntity, true);
            }

            $this->emailAdmin();
        }
        $io->success('Fruits have been added');

        return Command::SUCCESS;
    }

    private function fetchFruits(): array
    {
        $response = $this->httpClient->request(
            'GET',
            'https://fruityvice.com/api/fruit/all'
        );

        $content = $response->toArray();

        return $content;
    }

    private function emailAdmin()
    {
        $email = (new Email())
            ->from('fruitbot@example.com')
            ->to('test@gmail.com')
            ->subject('Fruits successfully Saved!')
            ->text('Fruit records have been saved successfully!')
            ->html('<p>Fruit records have been saved successfully!</p>');

        $this->mailer->send($email);
    }
}
