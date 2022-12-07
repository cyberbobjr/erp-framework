<?php
    declare(strict_types=1);

    namespace App\Core\Plugin;

    use App\Core\AppHookManager;
    use App\Core\Entity\AppEntity;
    use App\Core\Menu\AppMenu;
    use App\Core\Menu\AppMenuManager;
    use App\Core\Menu\AppSubMenu;
    use App\Model\Entity\AppPlugin;
    use Cake\Core\BasePlugin;
    use Cake\Core\PluginApplicationInterface;
    use Cake\ORM\TableRegistry;

    /**d
     * Class AppBasePlugin
     * Adding fields to existing Entity // see @see http://docs.phinx.org/en/latest/migrations.html#working-with-columns for description
     * $newColumns = [
     * 'column_name' => [
     *  'type'    => 'integer',
     *  'options' => [
     *      'null'  => TRUE,
     *      'limit' => 11
     *  ]
     * ]
     * ]
     * @package App\Core
     */
    abstract class AppBasePlugin extends BasePlugin
    {
        protected $extendFields = [];
        protected $menus = [];
        protected $hooks = [];

        protected function setMenus(array $menus, $menuName = NULL): void
        {
            $this->menus = $menus;
            if (count($this->menus) > 0 && $this->isPluginActivated()) {
                $this->configureMenus($menuName);
            }
        }

        protected function addSubmenu(string $menuName, string $position, array $array)
        {
            AppMenuManager::getInstance()
                ->addSubmenu($menuName, $position, $array);
        }

        public function setHooks(string $anchor, string $elementView)
        {
            $fullClassName = $this->getName() . '\\View\\Cell\\' . $elementView;
            $type = class_exists($fullClassName . 'Cell') ? 'cell' : 'element';
            return AppHookManager::getInstance()
                ->addHook($anchor, $this->getName() . '.' . $elementView, $type);
        }

        /**
         * @param array $extendFields
         */
        public function setExtendFields(array $extendFields): void
        {
            $this->extendFields = $extendFields;
        }

        /**
         * @return array
         */
        public function getExtendFields(): array
        {
            return $this->extendFields;
        }

        protected final function isPluginActivated(): bool
        {
            $appPluginTable = TableRegistry::getTableLocator()->get('AppPluginsManager.AppPlugins');
            $namespace = $this->getName();
            $appPlugin = $appPluginTable->find()
                ->where(['name' => $namespace])
                ->first();
            /** @var AppPlugin $appPlugin */
            return (!empty($appPlugin) && $appPlugin->activated == TRUE);
        }

        protected final function configureMenus($menuName)
        {
            $mainMenu = NULL;
            $subMenus = [];
            if (is_null($menuName)) {
                $menuName = $this->getName();
            }
            foreach ($this->menus as $menu) {
                $mainMenu = new AppMenu($menu['url'], $menu['label'], $menu['order'], $menu['icon']);
                foreach ($menu['submenus'] as $submenu) {
                    $subMenus[] = new AppSubMenu($submenu['url'], $submenu['label'], $submenu['order'], $submenu['icon']);
                }
                AppMenuManager::getInstance()
                    ->addMenu($menuName, $mainMenu, $subMenus, isset($menu['position']) ? $menu['position'] : 'left');
            }
        }

        public function activate()
        {
            // @todo : Add Menu
            try {
                if (count($this->extendFields) > 0) {
                    $this->addCustomFields();
                }
                return TRUE;
            } catch (\Exception $ex) {
                debug($ex->getMessage());
                return FALSE;
            }
        }

        public function deactivate()
        {
            // @todo : Remove Custom fields
            $this->removeCustomFields();
            return TRUE;
        }

        protected function addCustomFields()
        {
            foreach ($this->extendFields as $entity => $fields) {
                $this->addCustomFieldsToEntity($entity, $fields);
            }
        }

        protected function addCustomFieldsToEntity(string $entity, array $fields)
        {
            /** @var AppEntity $modifiedEntity */
            $modifiedEntity = new $entity();
            foreach ($fields as $fieldName => $fieldProperties) {
                $modifiedEntity::addNewField($fieldName, $fieldProperties);
            }
        }

        protected function removeCustomFields()
        {
            foreach ($this->extendFields as $entity => $fields) {
                $this->removeCustomField($entity, $fields);
            }
        }

        protected function removeCustomField(string $entity, array $fields)
        {
            /** @var AppEntity $modifiedEntity */
            $modifiedEntity = new $entity();
            foreach ($fields as $fieldName => $fieldProperties) {
                $modifiedEntity::removeField($fieldName);
            }
            return TRUE;
        }

        public function bootstrap(PluginApplicationInterface $app): void
        {
            parent::bootstrap($app); // TODO: Change the autogenerated stub
            if ($this->isPluginActivated() && count($this->hooks) > 0) {
                $this->loadHooks();
            }
        }

        protected function loadHooks()
        {
            foreach ($this->hooks as $anchor => $element) {
                $this->setHooks($anchor, $element);
            }
        }
    }
