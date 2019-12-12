<?php
/**
 * @var \App\View\AppView $this
 */

    use Cake\I18n\Time;

    $tableau = [];
for ($i = 5; $i >= 0; $i--) {
    if (isset($montants[$i])) {
        $tableau[] = [(new Time($montants[$i]['date_echeance']))->format('U') * 1000,
                      $montants[$i]['somme'],];
    }
}
?>
<script>

    $(function () {
        Highcharts.setOptions({
            lang: {
                months: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
                shortMonths: ['Jan', 'Fév', 'Mars', 'Avr', 'Mai', 'Juin', 'Juill', 'Août', 'Sept', 'Oct', 'Nov', 'Déc'],
                weekdays: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi']
            }
        });

        var myChart = Highcharts.chart('linegraph', {
            credits: {
                enabled: false
            },
            title: {
                text: null
            },
            xAxis: {
                type: 'datetime'
            },
            yAxis: {
                title: {
                    text: 'Total en €'
                }
            },
            series: [{
                type: "column",
                name: "Revenus",
                data: <?= json_encode($tableau, JSON_NUMERIC_CHECK)?>
            }]
        });
    });

</script>
<div class="panel panel-default">
    <div class="panel-heading"><?= __('A encaisser sur les 5 derniers mois') ?></div>
    <div class="panel-body">
        <div id="linegraph" style="height: 200px"></div>
    </div>
</div>
