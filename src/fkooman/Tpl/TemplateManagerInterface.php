<?php

namespace fkooman\Tpl;

interface TemplateManagerInterface
{
    /**
     * Set default template variables that are always used by the render
     * method, they will be overriden by the parameters specified in the render
     * method.
     *
     * @param array $templateVariables the variables to be used in the 
     *                                 template(s)
     */
    public function setDefault(array $templateVariables);

    /**
     * Render the template.
     *
     * @param string $templateName      the name of the template
     * @param array  $templateVariables the variables to be used in the 
     *                                  template
     *
     * @return string the rendered template
     */
    public function render($templateName, array $templateVariables);
}
