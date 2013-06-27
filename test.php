<?php
include dirname(__FILE__).'/helpers/table.php';
// include dirname(__FILE__).'/classes/html.php';

$helper = new h_table(array(
    array(
        'id' => 0,
        'lastname' => 'Doe',
        'firstname' => 'John'
    ),
    array(
        'id' => 1,
        'lastname' => 'Doe',
        'firstname' => 'Jean',
        'attr' => array(
            'class' => 'success'
        )
    )
), array(
    'caption' => 'A simple table',
    'thead' => array(
        'id' => array(
            'name' => 'Id'
        ),
        'lastname' => array(
            'name' => 'Last name'
        ),
        'firstname' => array(
            'name' => 'First name'
        ),
        'action' => array(
            'name' => 'Action',
            'attr' => array(
                'class' => 'action'
            )
        )
    ),
    'attr' => array(
        'class' => 'table table-condensed table-hover table-bordered',
        'data' => array(
            'test' => 'some value'
        )
    ),
), true);

die(var_dump($helper));