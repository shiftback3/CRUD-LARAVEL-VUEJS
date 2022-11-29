<?php


namespace App\Traits;

use App\Models\Employee;




trait ManagesEndpoints
{
    protected $endpoints = [
        'employee' => Employee::class,
        

    ];

    protected $rules = [
        'employee' => [
            'store' => [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'salary' => 'required',
                'department' => 'required',

            ],
            'update' => [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'salary' => 'required',
                'department' => 'required',
            ]
        ],

    ];
    protected $paginate = [
        'countries' => 10,
    ];

    protected $orderBy = [
      
    ];

    protected $path = []; 
}