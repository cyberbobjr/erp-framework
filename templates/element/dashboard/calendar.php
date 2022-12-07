<?php
/**
 * @var \App\View\AppView $this
 */

    use App\AppConstants;

?>
<style>
    .echeance_client {
        background-color: #008cba;
    }

    .fin_bail {
        background-color: #b077ff;
    }

    .btn-legend {
        margin-left: 5px;
        margin-right: 5px;
    }

    .legend-text {
        min-width: 100px;
    }

    .fc-event {
        border-radius: 0px;
    }
</style>
<script>
    /**
     * calendar.navigate('prev');
     calendar.navigate('today');
     calendar.navigate('next');
     */
    $(function () {
        $('#calendar').fullCalendar({
            locale: 'fr',
            eventSources: [
                // your event source
                {
                    url: '<?= $this->Url->build(['controller' => 'events',
                                                 'action'     => 'get'])?>',
                    type: 'POST',
                    data: {
                        type_event_id: <?= AppConstants::EVENT_ECHEANCE_CLIENT ?>
                    },
                    error: function () {
                        alert('there was an error while fetching events!');
                    },
                    color: '#008cba',
                    textColor: '#ffffff',
                    cache: true,
                    eventDataTransform: function (eventData) {
                        return eventData;
                    }
                },
                {
                    url: '<?= $this->Url->build(['controller' => 'events',
                                                 'action'     => 'get'])?>',
                    type: 'POST',
                    data: {
                        type_event_id: <?= AppConstants::EVENT_FIN_BAIL?>
                    },
                    error: function () {
                        alert('there was an error while fetching events!');
                    },
                    color: '#b077ff',
                    textColor: '#F0F0F0',
                    cache: true
                }
            ],
            eventClick: function (event, element) {
            },
            eventRender: function (event, element, view) {
                element.popover({
                    title: event.title,
                    content: event.description,
                    trigger: "hover focus",
                    html: true
                });
            }
        })
    })
</script>
<div id="calendar"></div>
<br/>
<div style="display: flex;justify-content: center;">
    <div class="btn-group btn-legend">
        <button class="btn btn-xs echeance_client" disabled type="button"> </button>
        <button class="btn btn-xs btn-default legend-text" disabled type="button"><?= __('Echéance client') ?></button>
    </div>
    <div class="btn-group btn-legend">
        <button class="btn btn-xs fin_bail" disabled type="button"> </button>
        <button class="btn btn-xs btn-default legend-text" disabled type="button"><?= __('Fin de bail') ?></button>
    </div>
</div>
