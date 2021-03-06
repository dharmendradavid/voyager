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
    public function authenticate($schemas)
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
                'applicationKey' => config('voyager.real_time_co.application_key'),
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
                'applicationKey' => config('voyager.real_time_co.application_key'),
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
                ],
                "provisionType" => 1,
                "provisionLoad" => 2
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
        $this->client->request('POST', config('voyager.real_time_co.auth_url') . '/deleteTable', [
            'json' => [
                'applicationKey' => config('voyager.real_time_co.application_key'),
                'privateKey' => config('voyager.real_time_co.private_key'),
                'authenticationToken' => config('voyager.real_time_co.authentication_token'),
                'table' => $table,
            ]
        ]);

        return $this;
    }

    /**
     * Function stores content inside a table in no sql database
     *
     * @param string $table Table to store content into
     * @param mixed $content Main content to be put
     * @return $this
     */
    public function storeItem($table, $content)
    {

        $content = $this->checkContent($content);

        $this->client->request('POST', config('voyager.real_time_co.auth_url') . '/putItem', [
            'json' => [
                'applicationKey' => config('voyager.real_time_co.application_key'),
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
     * @param mixed $primaryKey
     * @param mixed $secondaryKey
     * @return $this
     */
    public function deleteItem($table, $primaryKey, $secondaryKey)
    {
        $this->client->request('POST', config('voyager.real_time_co.auth_url') . '/deleteItem', [
            'json' => [
                'applicationKey' => config('voyager.real_time_co.application_key'),
                'privateKey' => config('voyager.real_time_co.private_key'),
                'authenticationToken' => config('voyager.real_time_co.authentication_token'),
                'table' => $table,
                "key" => [
                    'primary' => $primaryKey,
                    'secondary' => $secondaryKey
                ]
            ]
        ]);

        return $this;
    }

    /**
     * Function updates the table at given primary key with new content provided
     *
     * @param string $table Table being updated
     * @param string $primaryKey The primary search key for no sql database
     * @param string $secondaryKey The secondary search key for no sql database
     * @param mixed $content Content to be updated with
     * @return $this
     */
    public function updateItem($table, $primaryKey, $secondaryKey, $content)
    {
        unset($content[config('voyager.real_time_co.secondary_key_nosql')]);
        unset($content[config('voyager.real_time_co.primary_key_nosql')]);
        unset($content[config('voyager.real_time_co.media_items_secondary_key_nosql')]);
        unset($content[config('voyager.real_time_co.media_items_primary_key_nosql')]);

        $content = $this->checkContent($content);

        $this->client->request('POST', config('voyager.real_time_co.auth_url') . '/updateItem', [
            'json' => [
                'applicationKey' => config('voyager.real_time_co.application_key'),
                'privateKey' => config('voyager.real_time_co.private_key'),
                'authenticationToken' => config('voyager.real_time_co.authentication_token'),
                'table' => $table,
                "key" => [
                    'primary' => $primaryKey,
                    'secondary' => $secondaryKey
                ],
                'item' => $content
            ]
        ]);

        return $this;
    }

    /**
     * Function fetches the content from the no sql database for given table and key
     *
     * @param string $table Table name where content exists
     * @param mixed $key Primary search key
     * @return mixed
     */
    public function getItem($table, $key)
    {
        $content['meta_data'] = md5($key);

        $item = $this->client->request('POST', config('voyager.real_time_co.auth_url') . '/getItem', [
            'json' => [
                'applicationKey' => config('voyager.real_time_co.application_key'),
                'privateKey' => config('voyager.real_time_co.private_key'),
                'authenticationToken' => config('voyager.real_time_co.authentication_token'),
                'table' => $table,
                "key" => [
                    'primary' => $key,
                    'secondary' => md5($key)
                ]
            ]
        ]);

        return $item;
    }

    /**
     * Function fetches the all items from the table in no sql database
     *
     * @param string $table Table from which data is to be fetched
     * @param null $limit
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function listItems($table, $limit = null)
    {
        $lists = $this->client->request('POST', config('voyager.real_time_co.auth_url') . '/getItem', [
            'json' => [
                'applicationKey' => config('voyager.real_time_co.application_key'),
                'privateKey' => config('voyager.real_time_co.private_key'),
                'authenticationToken' => config('voyager.real_time_co.authentication_token'),
                'table' => $table,
            ]
        ]);

        return $lists;
    }

    /**
     * Function checks empty key values as "" and sets them as null
     *
     * @param array $content
     * @return array
     */
    private function checkContent(array $content)
    {

        return collect($content)->transform(function($item) {
            return $item == "" ? null : $item;
        })->toArray();
    }

}