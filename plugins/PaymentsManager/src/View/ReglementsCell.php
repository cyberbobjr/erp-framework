<?php

namespace App\View\Cell;

use Cake\View\Cell;

/**
 * Class ReglementsCell
 * @package App\View\Cell
 */
class ReglementsCell extends Cell
{

    public function display($operation_id)
    {
        $this->set(compact('operation_id'));
    }

    public function displayForUser($tier_id)
    {
        $this->set(compact('tier_id'));
    }
}

?>