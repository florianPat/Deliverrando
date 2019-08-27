<?php

namespace MyVendor\SitePackage\ViewHelper;

use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class FormFieldHelpViewHelper extends AbstractViewHelper
{
    /**
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument("tag", "string", "The tag to add to the form", true);
        $this->registerArgument("idPrefix", "string", "The string to add to the id of the tag and the p tag", true);
    }

    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $result = $arguments['tag'];

        $tagEnd = '/>';
        $endTagPos = strrpos($result, $tagEnd);
        $fullTagSize = strlen($result);
        $tagEndSize = strlen($tagEnd);
        assert($endTagPos == (strlen($result) - strlen($tagEnd)));
        $result = substr($result, 0, $endTagPos);

        $nameAttributeText = 'name="';
        $nameArgumentStartPos = strpos($result, $nameAttributeText);
        $nameArgumentStartPos += strlen($nameAttributeText);
        assert($nameArgumentStartPos < strlen($result));

        $classNameStartPos = strpos($result, '[', $nameArgumentStartPos) + 1;
        assert($classNameStartPos < strlen($result));
        $classNameEndPos = strpos($result, ']', $classNameStartPos);
        assert($classNameEndPos < strlen($result));
        $className = substr($result, $classNameStartPos, $classNameEndPos - $classNameStartPos);

        $propertyNameStartPos = strpos($result, '[', $classNameEndPos) + 1;
        assert($propertyNameStartPos < strlen($result));
        $propertyNameEndPos = strpos($result, ']', $propertyNameStartPos);
        assert($propertyNameEndPos < strlen($result));
        $propertyName = substr($result, $propertyNameStartPos, $propertyNameEndPos - $propertyNameStartPos);

        $idPrefix = 'formErr_' . $arguments['idPrefix'];
        $id = $idPrefix . $className . '.' . $propertyName;

        $result = sprintf('%s id="%s"><p id="msg_%s"></p> <br />', $result, $id, $id);

        return $result;
    }
}