<?php

namespace Adapters;

use Adapters\Interfaces\MongoDBAdapterInterface;
use MongoDB\Client;
use MongoDB\Database;

class MongoDBAdapter implements MongoDBAdapterInterface
{
    private Client $client;
    public Database $mongodbDatabase;
    public function __construct()
    {
        $uri = 'mongodb://' . env('MONGODB_USER') . ':' . env('MONGODB_PASSWORD') . '@' . env('MONGODB_HOST') . ':' . env('MONGODB_PORT') . '/';

        $this->client = new Client($uri);
        $this->mongodbDatabase =  $this->client->selectDatabase(env('MONGODB_DATABASE'));
    }

}
