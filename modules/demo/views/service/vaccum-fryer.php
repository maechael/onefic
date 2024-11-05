<?php

use edofre\fullcalendar\Fullcalendar;
use edofre\fullcalendar\models\Event;
use yii\web\JsExpression;

$events = [
    new Event([
        'title' => 'rawr' . rand(1, 999),
        'start' => '2022-02-18T14:00:00',
    ]),
    // Everything editable
    new Event([
        'id'               => uniqid(),
        'title'            => 'WAW',
        'start'            => '2022-02-17T12:30:00',
        'end'              => '2022-02-17T13:30:00',
        'editable'         => true,
        'startEditable'    => true,
        'durationEditable' => true,
    ]),
    // No overlap
    new Event([
        'id'               => uniqid(),
        'title'            => 'Appointment #' . rand(1, 999),
        'start'            => '2022-02-17T15:30:00',
        'end'              => '2022-02-17T19:30:00',
        'overlap'          => false, // Overlap is default true
        'editable'         => true,
        'startEditable'    => true,
        'durationEditable' => true,
    ]),
    // Only duration editable
    new Event([
        'id'               => uniqid(),
        'title'            => 'Appointment #' . rand(1, 999),
        'start'            => '2022-02-16T11:00:00',
        'end'              => '2022-02-16T11:30:00',
        'startEditable'    => false,
        'durationEditable' => true,
    ]),
    // Only start editable
    new Event([
        'id'               => uniqid(),
        'title'            => 'Appointment #' . rand(1, 999),
        'start'            => '2022-02-15T14:00:00',
        'end'              => '2022-02-17T12:30:00',
        'startEditable'    => true,
        'durationEditable' => false,
    ]),
];
?>

<?= Fullcalendar::widget([
    'options'       => [
        'id'       => 'calendar',
        'language' => 'en',
    ],
    'clientOptions' => [
        'weekNumbers' => true,
        'selectable'  => true,
        'defaultView' => 'month',
        'eventResize' => new JsExpression("
                function(event, delta, revertFunc, jsEvent, ui, view) {
                    console.log(event);
                }
            "),

    ],
    'events'        => $events
]);
?>