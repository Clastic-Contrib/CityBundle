<?php
/**
 * This file is part of the Clastic package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\CityBundle\Command;

use Clastic\CityBundle\Hydrator\Hydrator;
use Clastic\GeneratorBundle\ClasticGeneratorBundle;
use Clastic\GeneratorBundle\Generator\ModuleGenerator;
use Sensio\Bundle\GeneratorBundle\Command\GeneratorCommand;
use Sensio\Bundle\GeneratorBundle\Command\Helper\QuestionHelper;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

/**
 * Initializes a Clastic module inside a bundle.
 *
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class CityHydrateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('clastic:city:hydrate')
            ->setDescription('Hydrate the city module.')
            ->addOption('countries', null, InputOption::VALUE_REQUIRED, 'The countries to import.');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $questionHelper = $this->getQuestionHelper();

        if ($input->isInteractive()) {
            $question = new ConfirmationQuestion($questionHelper->getQuestion('Do you confirm generation', 'yes', '?'), true);
            if (!$questionHelper->ask($input, $output, $question)) {
                $output->writeln('<error>Command aborted</error>');

                return 1;
            }
        }

        $countries = explode(',', $input->getOption('countries'));

        $questionHelper->writeSection($output, 'Hydrating data');

        /** @var Hydrator $hydrator */
        $hydrator = $this->getContainer()->get('clastic_city_bundle.hydrator');

        foreach ($countries as $country) {
            $iterator = $this->getContainer()->get('clastic_city_bundle.resolver.' . $country);
            $progress = new ProgressBar($output, $iterator->count());
            $progress->start();
            $hydrator->hydrate(
                $iterator,
                $progress
            );
            $progress->finish();
        }

        $output->writeln('');
        $output->writeln('Hydrating cities: <info>OK</info>');

        $this->writeSection($output, 'You can now start using the data!');

        return 0;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $questionHelper = $this->getQuestionHelper();
        $questionHelper->writeSection($output, 'Welcome to the Clastic city hydrator');

        // namespace
        $output->writeln(array(
            '',
            'This command helps you hydrate city data for the Clastic CityBundle.',
            '',
        ));

        while (true) {
            $question = new Question($questionHelper->getQuestion('The countries', $input->getOption('countries')), $input->getOption('countries'));
            $countries = $questionHelper->ask($input, $output, $question);

            if (count(array_filter(explode(',', $countries)))) {
                break;
            }

            $output->writeln('<bg=red>Need at least one country.</>.');
        }
        $input->setOption('countries', $countries);

        // summary
        $output->writeln(array(
            '',
            $this->getHelper('formatter')->formatBlock('Summary before generation', 'bg=blue;fg=white', true),
            '',
            sprintf("You are going to hydrate for: \"<info>%s</info>\"", $input->getOption('countries')),
            '',
        ));
    }

    protected function getQuestionHelper()
    {
        $question = $this->getHelperSet()->get('question');
        if (!$question || get_class($question) !== 'Sensio\Bundle\GeneratorBundle\Command\Helper\QuestionHelper') {
            $this->getHelperSet()->set($question = new QuestionHelper());
        }

        return $question;
    }
}
