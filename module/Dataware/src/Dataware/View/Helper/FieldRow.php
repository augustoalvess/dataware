<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FieldRow
 *
 * @author augusto
 */
namespace Dataware\View\Helper;

use Zend\Form\View\Helper\FormRow;
use Zend\Form\ElementInterface;

class FieldRow extends FormRow
{
    public function render(ElementInterface $element)
    {   
        $escapeHtmlHelper    = $this->getEscapeHtmlHelper();
        $labelHelper         = $this->getLabelHelper();
        $elementHelper       = $this->getElementHelper();
        $elementErrorsHelper = $this->getElementErrorsHelper();

        $label           = $element->getLabel();
        $inputErrorClass = $this->getInputErrorClass();

        if (isset($label) && '' !== $label) {
            // Translate the label
            if (null !== ($translator = $this->getTranslator())) {
                $label = $translator->translate(
                    $label, $this->getTranslatorTextDomain()
                );
            }
        }

        // Does this element have errors ?
        if (count($element->getMessages()) > 0 && !empty($inputErrorClass)) {
            $classAttributes = ($element->hasAttribute('class') ? $element->getAttribute('class') . ' ' : '');
            $classAttributes = $classAttributes . $inputErrorClass;

            $element->setAttribute('class', $classAttributes);
        }

        if ($this->partial) {
            $vars = array(
                'element'           => $element,
                'label'             => $label,
                'labelAttributes'   => $this->labelAttributes,
                'labelPosition'     => $this->labelPosition,
                'renderErrors'      => $this->renderErrors,
            );

            return $this->view->render($this->partial, $vars);
        }

        if ($this->renderErrors) {
            $elementErrors = $elementErrorsHelper->render($element);
        }
        
        if ( $element->getOption('current_user') )
        {
            $element->setValue(NULL);
        }

        $elementString = $elementHelper->render($element);
        
        $labelAttributes = $element->getOption("labelAttributes");
        $labelRequired = "";
        
        if ( $labelAttributes['required'] )
        {
            $labelRequired = "<b class='required'>*</b>";
        }

        if (isset($label) && '' !== $label) {
            $label = $escapeHtmlHelper($label);
            $labelAttributes = $element->getLabelAttributes();

            if (empty($labelAttributes)) {
                $labelAttributes = $this->labelAttributes;
            }

            // Multicheckbox elements have to be handled differently as the HTML standard does not allow nested
            // labels. The semantic way is to group them inside a fieldset
            $type = $element->getAttribute('type');
            
            if ($element->hasAttribute('id')) {
                $labelOpen = '';
                $labelClose = '';
                $label = $labelHelper($element);
            } else {
                $labelOpen  = $labelHelper->openTag($labelAttributes);
                $labelClose = $labelHelper->closeTag();
            }

            if ($label !== '' && !$element->hasAttribute('id')) {
                $label = '<span>' . $label . '&nbsp;' . $labelRequired . '</span>';
            }

            // Button element is a special case, because label is always rendered inside it
            if ($element instanceof Button) {
                $labelOpen = $labelClose = $label = '';
            }

            switch ($this->labelPosition) {
                case self::LABEL_PREPEND:
                    $markup = $labelOpen . $label . $elementString . $labelClose;
                    break;
                case self::LABEL_APPEND:
                default:
                    $markup = $labelOpen . $elementString . $label . $labelClose;
                    break;
            }

            if ($this->renderErrors) {
                $markup .= $elementErrors;
            }
        } else {
            if ($this->renderErrors) {
                $markup = $elementString . $elementErrors;
            } else {
                $markup = $elementString;
            }
        }

        return "<div id='{$element->getName()}'>" . $markup . "</div>";
    }
}

?>
