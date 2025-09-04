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
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsCommand(name: 'app:ai:ask', description: 'Envía un prompt a OpenAI y muestra la respuesta')]
class AiAskCommand extends Command
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
        $prompt = (string) $input->getArgument('prompt');

        $apiKey = $this->params->get('openai.api_key');

        $platform = PlatformFactory::create($apiKey);


        $model = new Gpt(Gpt::GPT_5);
        $promise = $platform->invoke(
            $model,
            new MessageBag(Message::ofUser($prompt))
        );


        $result = $promise->getResult();
        $output->writeln($result->getContent());


        return Command::SUCCESS;
    }
}
