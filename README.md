# ERP Framework

Un framework ERP conçu avec [CakePHP 3.7](http://cakephp.org)

Version interne.

## Installation

1. Téléchargez [Composer](http://getcomposer.org/doc/00-intro.md) ou mettez à jour `composer self-update`.
2. Éxecutez `php composer.phar install`.

Cette dernière execution ne sera pas nécessaire sur la version finale de l'ERP Framework.
Allez ensuite sur l'url d'installation de votre serveur web :
http://localhost/install (si localhost) 


## Configuration

Suivez les instructions de l'installation pour configurer votre application.

## Fonctionnalités
AGILE ERP est conçu comme un système entièrement modulable et paramétrable. Les modules sont structurés sous la forme de "plugins" CakePHP.

Les fonctionnalités disponibles pour développer des plugins sont :
* Gestion des hooks pour permettre d'ajouter des éléments à une vue existante
* Ajout de champs personnalisés supplémentaires sur des entités (objets) métiers
* Menus personnalisés par plugin

### Configuration plugin
Le fichier "plugin.php" est l'élément central de la configuration d'un plugin. Il se trouve dans le répertoire "src" du plugin.

***un exemple de plugin "simple" est disponible dans le répertoire plugins/ExamplePlugin.***

Voici les différentes options de configuration :

__extendFields__

Cette propriété est protected dans la classe. Elle peut être affectée via un setter ou directement lors de la déclaration de la classe plugin.php
extendFields permet de spécifier l'extension d'un objet métier (Entity) avec des propriétés supplémentaires.
Ce doit être un tableau indexé par le chemin complet de l'entité que l'on désire étendre. La valeur de la clef est un tableau contenant les propriétés ajoutées pointant sur les options de la propriété ajoutée. 
Exemple :
```
 protected $extendFields = [
            'TiersManager\Model\Entity\Customer' => [
                'new_prop' => ['type'    => 'integer',
                               'options' => [
                                   'null' => TRUE]]
            ]];
```

``TiersManager\Model\Entity\Customer`` est l'entité métier à étendre

```new_prop``` est la propriété rajoutée à l'entité Customer. Cette nouvelle propriété est de type ```integer```qui ne doit pas être ```NULL```.

Les différents types et les différentes options sont indiqués dans la document de Phinx, un outil de migration de bases de données :

[Document de Phinx](http://docs.phinx.org/en/latest/index.html)


__hooks__

Les hooks (crochets) sont des éléments de vue qui s'insèrent dans des ancres (anchors). Les éléments de vue peuvent être de 2 types :
```element``` ou ```cell```. Ces 2 éléments sont intégrés dans le noyau de CakePHP.

Un ```element``` est une vue simple, elle peut disposer des variables déclarées dans la vue parente.
Une ```cell``` est une vue autonome associée à une action de la couche Controller.

Pour plus de précision sur le fonctionnement de ces 2 mécanismes, se référer à la doc de CakePHP.

La syntaxe pour déclarer une ancre dans le fichier plugin.php est la suivante :

```
 protected $hooks = [
            'OperationsManager.Operations.step1.action'       => 'CellSample',
            'OperationsManager.Operations.step1.beforeinputs' => 'new_input',
        ];
``` 

``'OperationsManager.Operations.step1.action'`` est la concaténation du chemin complet (namespace) de la vue (ici ``OperationsManager.Operations.step1``)suivie du nom de l'ancre sur laquelle raccrocher l'element ou le cell (ici ``action`` et ``beforeinputs``).

Le nom de l'élément à insérer est ``CellSample`` et ``new_input``.

* CellSample

``CellSample`` est un cell qui est déclaré dans l'autoload de CakePHP. Dans le cas des cells il est possible de précision l'action à executer en rajoutant ``::action`` après le nom du cell.
Example : 
```
 protected $hooks = [
            'OperationsManager.Operations.step1.action'       => 'CellSample::action',
            'OperationsManager.Operations.step1.beforeinputs' => 'new_input',
        ];
```

[Documentation sur les cells](https://book.cakephp.org/3.0/fr/views/cells.html)

* new_input

```new_input``` est le nom d'un élément à insérer dans la vue. Cet élément doit être présent dans le répertoire ``Template/Element`` du plugin installé.

Pour déclarer une ancre dans une vue, il faut appeler le Hooks Helper en indiquant le nom de l'ancre que l'on désire déclarer.
Pour notre exemple, dans le fichier ```step1.ctp``` situé à cette adresse ```OperationsManager/src/Template/Operations/step1.ctp``` nous pouvons déclarer 2 ancres ```action``` et ```beforeinputs``` comme suit :

```
<?= $this->Hooks->getHooks('action') ?>
<?= $this->Hooks->getHooks('beforeinputs') ?>
```

__menus__

Chaque plugin peut déclarer um menu ou s'insérer dans un menu existant.
La déclaration du ou des menus s'effectue également dans le fichier Plugin.php dans le répertoire src du plugin.

La déclaration du menu s'effectue dans la méthode `` public function routes($routes)``. La déclaration de menu peut utiliser le singleton ``Router`` pour forger des URLs applicatives à partir d'un tableau de paramètres.

Il existe 1 méthode pour créer un menu et 1 méthode pour s'insérer dans un menu existant.

* Création d'un menu dédié

Pour créer un menu il faut utiliser la méthode ``setMenus`` avec les paramètres du menu.
exemple :
```
$this->setMenus([
                    [
                         'url'      => '#',
                         'label'    => 'Example plugin',
                         'order'    => 0,
                         'position' => 'right',
                         'icon'     => '<i class="fa fa-question"></i>&nbsp;',
                         'submenus' => [
                                            [
                                                'url'   => Router::url(['controller' => 'Tiers',
                                                                        'action'     => 'add',
                                                                        'plugin'     => 'TiersManager']),
                                               'label' => __('Créer un tiers'),
                                               'order' => 0,
                                               'icon'  => ''
                                            ]
                                      ]
                     ]
                ], 'ExamplePlugin');
```
note : la propriété `order` n'est pas encore implémentée.
note : la clef ``url`` peut être soit une URL absolue, soit une URL relative, soit une URL construite avec ``Router```

Le dernier paramètre de ``setMenus`` est le nom du menu déclaré, qui pourra être utilisé dans le cas d'une insertion de menu par d'autres plugins (voir point suivant).

* Insertion dans un menu existant (@TODO : à factoriser pour simplifier)
Pour s'insérer dans un menu existant, il faut utiliser la méthode ``addSubMenu`` avec les paramétres adéquats.

exemple :
```
$submenus = new AppMenu('#', 'test config', 0, '');
$this->addSubmenu('Configuration', 'right', [$submenus]);
```
La différence avec ``setMenus`` est l'instanciation de la classe AppMenu et l'insertion de l'objet instancié via la méthode ``assSubMenu``.
``addSubMenu`` nécessite 3 paramètres :
* le nom du menu existant tel que déclaré par ``setMenus``
* la position du menu (@TODO : à corriger)
* un tableau des objets Menus à insérer

__Personnalisation des formulaires__

//@TODO : à terme il est probable que la gestion des champs formulaire d'une entité soit plus avancée (gestion des types, des liens, des règles, etc.)

Il est possible de personnaliser les formulaires d'édition d'une entité. La fonction ``getLabelForField`` renvoit les labels selon le champ spécifié en paramètre.
Pour définir les labels, il faut initialiser le tableau ``_fieldControls`` qui est une propriété protégée d'une entité.

Exemple :
```
public function __construct(array $properties = [], array $options = [])
        {
            parent::__construct($properties, $options);
            $this->_fieldLabel = [
                'email'        => __('Email :'),
                'lastname'     => __('Nom :'),
                'firstname'    => __('Prénom :'),
                'company_name' => __('Société :'),
                'vat'          => __('Soumis à la TVA ? :'),
                'address1'     => __('Adresse :'),
                'address2'     => __('Adresse (complément) :'),
                'zipcode'      => __('Code postal :'),
                'city'         => __('Ville :'),
            ];
        }
``` 

## Liste des Hooks du Noyau
### Operations
OperationsManager.Operations.step1.beforeinputs

OperationsManager.Operations.step1.afterinputs

OperationsManager.Operations.step1.action

### Customers
TiersManager.Customers.add.beforeinputs

TiersManager.Customers.add.afterinputs

TiersManager.Customers.add.action
