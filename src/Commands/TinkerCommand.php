<?php


namespace PatentLobster\StinkerPhar\Commands;

use Illuminate\Support\Collection;
use Laravel\Tinker\ClassAliasAutoloader;
use Psy\Configuration;
use Psy\Shell;
use Symfony\Component\Console\Output\BufferedOutput;
use PatentLobster\StinkerPhar\Lib\CustomExecutionLoopClosure;
use Symfony\Component\Console\Output\StreamOutput;

class TinkerCommand
{

    /** @var \Symfony\Component\Console\Output\BufferedOutput */
    protected $output;

    /** @var \Psy\Shell */
    protected $shell;

    private $params;
    private $path;

    public function __construct($params, $path)
    {
        $this->params = $params;
        $this->path   = $path;
        $this->output = new BufferedOutput();
        $this->shell = $this->createShell($this->output);
    }

    protected function createShell($output): Shell
    {
        $config = new Configuration([
            'updateCheck' => 'never',
            'usePcntl' => false
        ]);

        $config->setHistoryFile(defined('PHP_WINDOWS_VERSION_BUILD') ? 'null' : '/dev/null');

        $config->getPresenter()->addCasters([
            Collection::class => 'Laravel\Tinker\TinkerCaster::castCollection',
            Model::class => 'Laravel\Tinker\TinkerCaster::castModel',
            Application::class => 'Laravel\Tinker\TinkerCaster::castApplication',
        ]);

        $shell = new Shell($config);


        $shell->setOutput($output);

        $composerClassMap = base_path('vendor/composer/autoload_classmap.php');

        if (file_exists($composerClassMap)) {
            ClassAliasAutoloader::register($shell, $composerClassMap);
        }

        return $shell;
    }

    protected function cleanOutput(string $output): string
    {
        $output = preg_replace('/(?s)(<aside.*?<\/aside>)|Exit:  Ctrl\+D/ms', '$2', $output);

        return trim($output);
    }

    public function execute() {
        if (isset($this->params->tinker_from)) {
            $phpCode = file_get_contents($this->params->tinker_from);
        }

        $this->shell->addInput($phpCode);
        $closure = new CustomExecutionLoopClosure($this->shell);
        $closure->execute();
        $output = $this->cleanOutput($this->output->fetch());
        return $output;
    }

}