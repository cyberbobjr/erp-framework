<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Model\Table\DocumentstiersTable;
use Cake\Http\Exception\NotFoundException;
use Cake\Utility\Hash;
use Symfony\Component\Config\Definition\Exception\Exception;


/**
 * CakePHP BiensController
 * @author Benjamin
 * @property DocumentstiersTable $Documentstiers
 */
class DocumentstiersController extends AppController
{

    /**
     * Fonction qui détermine les actions autorisées pour l'utilisateur connecté
     *
     * @param type $user Paramètre représentant l'entité utilisateur
     * @return boolean TRUE si l'action est autorisée, FALSE si non
     */
    public function isAuthorized($user)
    {
        // Les compteurs utilisateurs ayant le rôle d'administrateur ont tous les droits
        return ($user) ? TRUE : FALSE;
    }

    public function download($document_id = NULL)
    {
        if (is_null($document_id) || !$this->Documentstiers->exists(['id' => $document_id])) {
            throw new NotFoundException(__('Référence non trouvée'));
        }

        $document = $this->Documentstiers->get($document_id);
        //APP . DS . 'pdf' . DS . $document->filename . '.pdf'
        $response = $this->response->withFile(ROOT . DS . 'files' . DS . 'Documentstiers' . DS . 'file' . DS . $document->tier_id . DS . $document->file);
        return $response;
    }

    public function add($tier_id = NULL)
    {
        try {
            if (is_null($tier_id) || !$this->Documentstiers->Tiers->exists(['id' => $tier_id])) {
                throw new NotFoundException(__('Référence du tier introuvable'));
            }

            $document = $this->Documentstiers->newEntity($this->request->getData());
            if ($this->Documentstiers->save($document)) {
                $this->set('success', TRUE);
                $this->set('document', $document);
            } else {
                $errors = Hash::flatten($document->getErrors());
                throw new \Exception(join(",", $errors));
            }
        } catch (Exception $ex) {
            $this->set('errors', $ex->getMessage());
        }
    }

    public function supprimer()
    {
        if (!($this->request->getData('document_id'))) {
            throw new NotFoundException(__('Référence du document invalide'));
        }
        $document_id = $this->request->getData('document_id');
        $document = $this->Documentstiers->get($document_id);
        unlink(ROOT . DS . $document->file_dir . DS . $document->file);
        $this->Documentstiers->delete($document);
        $body = __('Fichier effacé');
        $this->set('body', $body);
    }

    /**
     * @param null $tier_id
     */
    public function getTable($tier_id = NULL)
    {
        if (is_null($tier_id)) {
            throw new NotFoundException(__('Référence introuvable'));
        }
        $documents = $this->Documentstiers->find()
                                          ->where(['tier_id' => $tier_id])
                                          ->contain(['TypeDocumentstiers']);
        $this->set(compact('documents'));
    }
}
