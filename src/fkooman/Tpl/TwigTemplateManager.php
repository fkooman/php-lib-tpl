<?php

namespace fkooman\Tpl;

use Twig_Loader_Filesystem;
use Twig_Environment;
use RuntimeException;

class TwigTemplateManager implements TemplateManagerInterface
{
    /** @var Twig_Environment */
    private $twig;

    /** @var array */
    private $defaultVariables;

    /**
     * Create TwigTemplateManager.
     *
     * @param array  $templateDirs template directories to look in where later
     *                             paths override the earlier paths
     * @param string $cacheDir     the writable directory to store the cache
     */
    public function __construct(array $templateDirs, $cacheDir = null)
    {
        $existingTemplateDirs = array();
        foreach ($templateDirs as $templateDir) {
            if (false !== is_dir($templateDir)) {
                $existingTemplateDirs[] = $templateDir;
            }
        }
        $existingTemplateDirs = array_reverse($existingTemplateDirs);

        $environmentOptions = array(
            'strict_variables' => true,
        );

        if (null !== $cacheDir) {
            if (false === is_dir($cacheDir)) {
                if (false === @mkdir($cacheDir)) {
                    throw new RuntimeException('unable to create template cache directory');
                }
            }
            $environmentOptions['cache'] = $cacheDir;
        }

        $this->twig = new Twig_Environment(
            new Twig_Loader_Filesystem(
                $existingTemplateDirs
            ),
            $environmentOptions
        );

        $this->defaultVariables = array();
    }

    public function setDefault(array $templateVariables)
    {
        $this->defaultVariables = $templateVariables;
    }

    public function render($templateName, array $templateVariables = array())
    {
        $templateVariables = array_merge($this->defaultVariables, $templateVariables);

        return $this->twig->render(
            sprintf(
                '%s.twig',
                $templateName
            ),
            $templateVariables
        );
    }
}
