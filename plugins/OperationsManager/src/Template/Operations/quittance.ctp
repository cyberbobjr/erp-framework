<?php
/**
 * @var \App\View\AppView $this
 * @var \OperationsManager\Model\Entity\Operation $operation
 */

    use NumberToWords\NumberToWords;

    $numberToWords = new NumberToWords();
$currencyTransformer = $numberToWords->getNumberTransformer('fr');
?>
<html>
<head>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10pt;
        }

        p {
            margin: 0pt;
        }

        table {
            font-family: Arial, Helvetica, sans-serif;
            color: #666;
            font-size: 12px;
            text-shadow: 1px 1px 0px #fff;
            background: #eaebec;
            margin: 20px;
            border: #ccc 1px solid;

            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            border-radius: 3px;

            -moz-box-shadow: 0 1px 2px #d1d1d1;
            -webkit-box-shadow: 0 1px 2px #d1d1d1;
            box-shadow: 0 1px 2px #d1d1d1;
        }

        table th {
            padding: 21px 25px 22px 25px;
            border-top: 1px solid #fafafa;
            border-bottom: 1px solid #e0e0e0;

            background: #ededed;
            background: -webkit-gradient(linear, left top, left bottom, from(#ededed), to(#ebebeb));
            background: -moz-linear-gradient(top, #ededed, #ebebeb);
        }

        table th:first-child {
            text-align: left;
            padding-left: 20px;
        }

        table tr:first-child th:first-child {
            -moz-border-radius-topleft: 3px;
            -webkit-border-top-left-radius: 3px;
            border-top-left-radius: 3px;
        }

        table tr:first-child th:last-child {
            -moz-border-radius-topright: 3px;
            -webkit-border-top-right-radius: 3px;
            border-top-right-radius: 3px;
        }

        table tr {
            text-align: center;
            padding-left: 20px;
        }

        table td:first-child {
            text-align: left;
            padding-left: 20px;
            border-left: 0;
        }

        table td {
            text-align: left;
            padding: 18px;
            border-top: 1px solid #ffffff;
            border-bottom: 1px solid #e0e0e0;
            border-left: 1px solid #e0e0e0;

            background: #fafafa;
            background: -webkit-gradient(linear, left top, left bottom, from(#fbfbfb), to(#fafafa));
            background: -moz-linear-gradient(top, #fbfbfb, #fafafa);
        }

        table tr.even td {
            background: #f6f6f6;
            background: -webkit-gradient(linear, left top, left bottom, from(#f8f8f8), to(#f6f6f6));
            background: -moz-linear-gradient(top, #f8f8f8, #f6f6f6);
        }

        table tr:last-child td {
            border-bottom: 0;
        }

        table tr:last-child td:first-child {
            -moz-border-radius-bottomleft: 3px;
            -webkit-border-bottom-left-radius: 3px;
            border-bottom-left-radius: 3px;
        }

        table tr:last-child td:last-child {
            -moz-border-radius-bottomright: 3px;
            -webkit-border-bottom-right-radius: 3px;
            border-bottom-right-radius: 3px;
        }

        table tr:hover td {
            background: #f2f2f2;
            background: -webkit-gradient(linear, left top, left bottom, from(#f2f2f2), to(#f0f0f0));
            background: -moz-linear-gradient(top, #f2f2f2, #f0f0f0);
        }

        caption {
            padding: 0.3em;
        }

        html {
            font-family: sans-serif;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        body {
            margin: 0;
        }
    </style>
</head>
<body>
<table width="100%">
    <thead>
    <tr>
        <th width="100%"><?= __('Quittance de loyer N°') . $operation->id ?></th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>
            Reçu de M.<?= $operation->client->nom_complet ?> la somme
            de <?= $currencyTransformer->toWords($operation->paye, 'EUR') ?> EUROS.<br/>
            Pour le montant d'un <?= $operation->bail->type_periodicite->libelle ?> de loyer des locaux qu'il occupe
            dans le logement
            situé <?= $operation->bail->bien->adresse1 . ' ' . $operation->bail->bien->code_postal . ' ' . $operation->bail->bien->ville ?>
            le dit <?= $operation->bail->type_periodicite->libelle ?> commencant
            le <?= $this->Time->format($operation->debut_periode, 'dd/MM/YY') ?> et finissant
            le <?= $this->Time->format($operation->fin_periode, 'dd/MM/YY') ?> sous toutes réserves de droit DONT
            QUITTANCE.
        </td>
    </tr>
    </tbody>
</table>
<br/>
<table width="100%">
    <thead>
    <tr>
        <th width="100%"><?= __('Expéditeur') ?></th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>
            <?= $operation->bail->societe->raison_sociale ?>&nbsp;
            <?php
            if (!empty($operation->bail->societe->capital_plancher)) {
                $capital_plancher = number_format($operation->bail->societe->capital_plancher, 2, ".", " ");
                echo __('à capital variable au capital plancher de {0} €', $capital_plancher);
            }
            ?>
            <br/>
            <?= $operation->bail->societe->adresse1 ?><br/>
            <?= $operation->bail->societe->code_postal . ' ' . $operation->bail->societe->ville ?>
        </td>
    </tr>
    </tbody>
</table>
<br/>
<table width="100%">
    <thead>
    <tr>
        <th width="15%"><?= __('Type') ?></th>
        <th width="45%"><?= __('Désignation') ?></th>
        <?php if ($operation->bail->societe->tva): ?>
            <th><?= __('Montant HT (€)') ?></th>
            <th><?= __('TVA (€)') ?></th>
        <?php endif; ?>
        <th><?= __('Montant TTC (€)') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($operation->operationdetails as $detail): ?>
        <tr>
            <td><?= $detail->type_operation->libelle ?></td>
            <td><?= $detail->libelle ?></td>
            <?php if ($operation->bail->societe->tva): ?>
                <td align="right"><?= number_format($detail->montant_ht, 2, ",", " ") ?>€</td>
                <td align="right"><?= number_format($detail->montant_tva, 2, ",", " ") ?>€</td>
            <?php endif; ?>
            <td align="right"><?= number_format($detail->montant_ttc, 2, ",", " ") ?>€</td>
        </tr>
    <?php endforeach ?>
    <tr>
        <td class="totals" align="right" colspan="<?= $operation->bail->societe->tva ? '4' : '2' ?>"><?= __('Total € TTC') ?></td>
        <td align="right" class="totals"><?= number_format($operation->total_ttc, 2, ",", " ") ?>€</td>
    </tr>
    </tbody>
</table>
<table width="100%">
    <thead>
    <tr>
        <th width="100%" style="border: 0.1mm solid #888888;">
            <?= $operation->bail->societe->commentaires ?>
        </th>
    </tr>
    </thead>
</table>
</body>
</html>
