<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DocumentsManager\Controller;

use App\Model\Table\DocumentsTable;
use Cake\Http\Exception\NotFoundException;
use Cake\Network\Email\Email;
use Cake\Network\Response;

/**
 * CakePHP BiensController
 * @author Benjamin
 * @property DocumentsTable $Documents
 */
class DocumentsController extends AppController
{

    /**
     * Fonction qui détermine les actions autorisées pour l'utilisateur connecté
     *
     * @param type $user Paramètre représentant l'entité utilisateur
     * @return boolean TRUE si l'action est autorisée, FALSE si non
     */
    public function isAuthorized($user)
    {
        return ($user) ? TRUE : FALSE;
    }


    /**
     * Fonction pour télécharger un fichier
     * @param null $document_id
     * @return Response|null
     */
    public function download($document_id = NULL)
    {
        if (is_null($document_id) || !$this->Documents->exists(['id' => $document_id])) {
            throw new NotFoundException(__('Référence non trouvée'));
        }

        $document = $this->Documents->get($document_id);
        if (file_exists(ROOT . DS . 'PDF' . DS . $document->file)) {
            return $this->response->withFile(ROOT . DS . 'PDF' . DS . $document->file);
        } else {
            $this->Flash->error(__('Le document a été supprimé du serveur'));
            $this->redirect($this->referer());
        }
    }

    /**
     * Fonction pour supprimer le document
     * @param int $document_id Référence du document à supprimer
     * @return Response|void
     */
    public function delete($document_id = NULL)
    {
        if (!$this->request->getData('operation_id')) {
            throw new NotFoundException(__('Référence à l\'opération non trouvée'));
        }
        $operation_id = $this->request->getData('operation_id');
        $entity = $this->Documents->get($document_id);
        if ($this->Documents->delete($entity)) {
            $this->Flash->success(__('Fichier supprimé'));
        } else {
            $this->Flash->error(__('Erreur lors de la suppression du fichier'));
        }
        $this->redirect(['controller' => 'operations',
                         'action'     => 'add',
                         $operation_id]);
    }

    /**
     * Envoi un document par courriel
     */
    public function sendcourriel()
    {
        $error = TRUE;
        $msg = __('Des informations sont manquantes (courriel vide, ou message vide)');
        $document_id = $this->request->getData('document_id');
        $message = $this->request->getData('message');
        $courriel = $this->request->getData('courriel');
        $subject = $this->request->getData('subject');
        if (!empty($document_id) && !empty($message) && !empty($courriel) && !empty($subject)) {
            // récupération du document
            $document = $this->Documents->get($document_id)
                                        ->toArray();
            //$this->send_doc(APP_DIRS.)
            $filename = APP . 'PDF' . DS . $document['file'];
            if ($this->send_doc($filename, $courriel, $subject, $message)) {
                $error = FALSE;
                $msg = __('Document envoyé');
            } else {
                $msg = __('Erreur lors de l\'envoi du mail');
            }
        }
        $this->set('_serialize', ['error' => $error,
                                  'msg'   => $msg]);
    }

    private function send_doc($filename, $courriel, $subject, $message)
    {
        // on s'assure que le fichier PDF a bien été généré
        if (file_exists($filename)) {
            // on récupère la liste des destinataires
            // si les courriels sont définis on envoie le mail
            $email = new Email('default');
            $email->transport('default');
            $email->attachments($filename)
                  ->from(['m_jd@hotmail.fr' => 'Joel MARCHAND'])
                  ->to($courriel)
                  ->emailFormat('both')
                  ->subject($subject)
                  ->send($message);
            return TRUE;
        }
        return FALSE;
    }
}
