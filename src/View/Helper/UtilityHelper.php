<?php

    namespace App\View\Helper;

    use App\Core\Entity\AppEntity;
    use BootstrapUI\View\Helper\FormHelper;
    use Cake\View\Helper\HtmlHelper;
    use Cake\View\Helper\UrlHelper;

    /**
     * Utility helper
     *
     * @property UrlHelper  $Url
     * @property HtmlHelper $Html
     */
    class UtilityHelper extends FormHelper
    {
        /**
         * @param  AppEntity  $entity
         * @return string
         */
        public function entityControl(\App\Core\Entity\AppEntity $entity)
        {
            $output = [];
            foreach ($entity->getFieldsType() as $fieldName => $property) {
                $options = ['label' => $entity->getLabelForField($fieldName)];
                $formType = $entity->getFormType($fieldName);
                if ($formType !== NULL) {
                    /** @noinspection SlowArrayOperationsInLoopInspection */
                    $options = array_merge($options, $formType::getOptions());
                }
                $index = $entity->getFieldControlOrder($fieldName);
                $index = empty($index) ? count($output) : $index;
                $output[$index] = Parent::control($fieldName, $options);
            }
            ksort($output);
            return implode('', $output);
        }

        public function postLinkBoostrap($title, $url = NULL, array $options = [])
        {
            $options += ['block' => NULL, 'confirm' => NULL];
            $requestMethod = 'POST';
            if (!empty($options['method'])) {
                $requestMethod = strtoupper($options['method']);
                unset($options['method']);
            }
            $confirmMessage = $options['confirm'];
            unset($options['confirm']);
            $formName = str_replace('.', '', uniqid('post_', TRUE));
            $formOptions = ['name' => $formName, 'style' => 'display:none;', 'method' => 'post'];
            if (isset($options['target'])) {
                $formOptions['target'] = $options['target'];
                unset($options['target']);
            }
            $templater = $this->templater();
            $restoreAction = $this->_lastAction;
            $this->_lastAction($url);
            $action = $templater->formatAttributes(['action' => $this->Url->build($url), 'escape' => FALSE]);
            $out = $this->formatTemplate('formStart', ['attrs' => $templater->formatAttributes($formOptions).$action]);
            $out .= $this->hidden('_method', ['value' => $requestMethod, 'secure' => static::SECURE_SKIP]);
            $out .= $this->_csrfField();
            $fields = [];
            if (isset($options['data']) && is_array($options['data'])) {
                foreach (\Cake\Utility\Hash::flatten($options['data']) as $key => $value) {
                    $fields[$key] = $value;
                    $out .= $this->hidden($key, ['value' => $value, 'secure' => static::SECURE_SKIP]);
                }
                unset($options['data']);
            }
            $out .= $this->secure($fields);
            $out .= $this->formatTemplate('formEnd', []);
            $this->_lastAction = $restoreAction;
            if ($options['block']) {
                if ($options['block'] === TRUE) {
                    $options['block'] = __FUNCTION__;
                }
                $this->_View->append($options['block'], $out);
                $out = '';
            }
            unset($options['block']);
            $url = '#';
            $onClick = 'document.'.$formName.'.submit();';
            if ($confirmMessage) {
                $options['onclick'] = "bootbox.confirm('{$confirmMessage}', function(result){\n                        if(result){\n                            {$onClick}\n                        }\n                    });";
            } else {
                $options['onclick'] = $onClick.' ';
            }
            $options['onclick'] .= 'event.returnValue = false; return false;';
            $out .= $this->Html->link($title, $url, $options);
            return $out;
        }
    }
