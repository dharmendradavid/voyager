<?php

namespace TCG\Voyager;


use GuzzleHttp\Client;

class NoSqlWrapper
{
    /**
     * @var Client
     */
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Function authenticates the system to take action against tables and database
     *
     * @param $schemas
     * @return $this
     */
    protected function authenticate($schemas)
    {
        $table = [
            "schema" => [
                "allow" => "CRUD"
            ],
        ];

        foreach ($schemas as $schema) {
            $table[$schema['name']] = [
                'allow' => "CURD"
            ];
        }

        $this->client->request('POST', config('voyager.real_time_co.auth_url') . '/authenticate', [
            'json' => [
                'applicationKey'=> config('voyager.real_time_co.application_key'),
                'privateKey' => config('voyager.real_time_co.private_key'),
                'authenticationToken' => config('voyager.real_time_co.authentication_token'),
                'policies' => [
                    "database" => config('voyager.real_time_co.database'),
                    "tables" => $table
                ],
                'timeout' => '999999'
            ]
        ]);

        return $this;
    }

    /**
     * Function creates a table in no sql database and makes an entry in schema table in database
     *
     * @param $schema
     * @return $this
     */
    public function createTable($schema)
    {
        $this->client->request('POST', config('voyager.real_time_co.auth_url') . '/createTable', [
            'json' => [
                'applicationKey'=> config('voyager.real_time_co.application_key'),
                'privateKey' => config('voyager.real_time_co.private_key'),
                'authenticationToken' => config('voyager.real_time_co.authentication_token'),
                'table' => $schema['name'],
                "key" => [
                    "primary" => [
                        "name" => $schema['key']['primary']['name'],
                        "dataType" => $schema['key']['primary']['dataType'],
                    ],
                    "secondary" => [
                        "name" => $schema['key']['secondary']['name'],
                        "dataType" => $schema['key']['secondary']['dataType'],
                    ]
                ]
            ]
        ]);

        return $this;
    }

    /**
     * Function deletes the table from no sql database
     *
     * @param string $table Table name to be deleted
     * @return $this
     */
    public function deleteTable($table)
    {
        //deleting table from database
        $this->client->request('POST', config('voyager.real_time_co.auth_url') . '/createTable', [
            'json' => [
                'applicationKey'=> config('voyager.real_time_co.application_key'),
                'privateKey' => config('voyager.real_time_co.private_key'),
                'authenticationToken' => config('voyager.real_time_co.authentication_token'),
                'table' => $table,
            ]
        ]);

        //deleting entry of table from schema
        $this->deleteItem($table, [
            'primary' => $table,
            'secondary' => md5($table)
        ]);

        return $this;
    }

    /**
     * Function stores content inside a table in no sql database
     *
     * @param string $table Table to store content into
     * @param string $keyIndex Index which will be the primary key
     * @param mixed $content Main content to be put
     * @return $this
     */
    public function putItem($table, $keyIndex, $content)
    {

        $content['meta_data'] = md5($keyIndex);

        $this->client->request('POST', config('voyager.real_time_co.auth_url') . '/putItem', [
            'json' => [
                'applicationKey'=> config('voyager.real_time_co.application_key'),
                'privateKey' => config('voyager.real_time_co.private_key'),
                'authenticationToken' => config('voyager.real_time_co.authentication_token'),
                'table' => $table,
                "item" => $content
            ]
        ]);

        return $this;
    }

    /**
     * Function delete's item from table at given key
     *
     * @param string $table
     * @param array $key
     * @return $this
     */
    public function deleteItem($table, $key)
    {
        $this->client->request('POST', config('voyager.real_time_co.auth_url') . '/putItem', [
            'json' => [
                'applicationKey'=> config('voyager.real_time_co.application_key'),
                'privateKey' => config('voyager.real_time_co.private_key'),
                'authenticationToken' => config('voyager.real_time_co.authentication_token'),
                'table' => $table,
                "key" => [
                    'primary' => $key,
                    'secondary' => md5($key)
                ]
            ]
        ]);

        return $this;
    }

    /**
     * Function updates the table at given primary key with new content provided
     *
     * @param string $table Table being updated
     * @param string $key The primary search key for no sql database
     * @param mixed $content Content to be updated with
     * @return $this
     */
    public function updateItem($table, $key, $content)
    {
        $content['meta_data'] = md5($key);

        $this->client->request('POST', config('voyager.real_time_co.auth_url') . '/putItem', [
            'json' => [
                'applicationKey'=> config('voyager.real_time_co.application_key'),
                'privateKey' => config('voyager.real_time_co.private_key'),
                'authenticationToken' => config('voyager.real_time_co.authentication_token'),
                'table' => $table,
                "key" => [
                    'primary' => $key,
                    'secondary' => md5($key)
                ],
                'item' => $content
            ]
        ]);

        return $this;
    }

}