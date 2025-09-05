<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\AI\Platform\Bridge\OpenAi\Embeddings;
use Symfony\AI\Platform\Bridge\OpenAi\Gpt;
use Symfony\AI\Platform\Bridge\OpenAi\PlatformFactory;
use Symfony\AI\Platform\Message\Message;
use Symfony\AI\Platform\Message\MessageBag;
use Symfony\AI\Platform\Vector\Vector;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsCommand(name: 'app:ai:embedding-ask', description: 'Envía un prompt a OpenAI y muestra la respuesta')]
class AiEmbeddingAskCommand extends Command
{
    public function __construct(private ParameterBagInterface $params)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('prompt', InputArgument::REQUIRED, 'Texto a enviar al modelo');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $query = (string) $input->getArgument('prompt');

        $apiKey = $this->params->get('openai.api_key');

        $platform = PlatformFactory::create($apiKey);

        $embeddings = new Embeddings();
        $items = [
            'Introducción a Symfony y mejores prácticas',
            'Machine Learning aplicado a educación superior',
            'Historia del arte contemporáneo',
            'Gestión financiera universitaria con casos prácticos',
            'Procesamiento de lenguaje natural para chatbots',
        ];

        $vectors = [];
        foreach ($items as $text) {
            $vectors[$text] = $platform->invoke($embeddings, $text)->getResult();
        }

        return Command::SUCCESS;
    }



}
