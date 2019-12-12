<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\View\CellTrait;

/**
 * CakePHP DashboardsController
 * @author Benjamin
 * @property \Cake\ORM\Table $Dashboards
 */
class DashboardsController extends AppController
{
    use CellTrait;

    /**
     * Fonction qui détermine les actions autorisées pour l'utilisateur connecté
     *
     * @param type $user Paramètre représentant l'entité utilisateur
     * @return boolean TRUE si l'action est autorisée, FALSE si non
     */
    public function isAuthorized($user): bool
    {
        return parent::isAuthorized($user);
    }

    public function index()
    {
    }

}
