<?php

return [

    /*
    |--------------------------------------------------------------------------
    | CRUD Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during CRUD proccess for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'success' => [
        'saved' => 'The record was successfully saved.',
        'deleted' => 'The record was successfully deleted.'
    ],
    'record_not_found' => 'The selected record was not found to be :action.',
    'client_has_orders' => 'Sorry, this client has :qtdOrders order. It can\'t be deleted!|Sorry, this client has :qtdOrders orders. It can\'t be deleted!',
    'category_has_products' => 'Sorry, this category has :qtdProducts product. It can\'t be deleted!|Sorry, this category has :qtdProducts products. It can\'t be deleted!',
    'cupom_was_used' => 'This cupom was used by an order. It can\'t be deleted.',
    'info' => [
        'nothing_to_be_saved' => 'Don\'t worry, nothing needed to be updated!',
    ],

];
