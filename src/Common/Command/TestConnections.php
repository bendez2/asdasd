<?php
declare(strict_types=1);

namespace Common\Command;

use Aws\Exception\AwsException;
use Aws\S3\S3Client;
use co;
use Exception;
use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Command\Annotation\Command;
use Hyperf\Context\ApplicationContext;
use Hyperf\DbConnection\Db;
use MongoDB\Client;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exception\AMQPTimeoutException;
use Swoole\Coroutine\PostgreSQL;
use ClickHouseDB;
use Adapters\MongoDBAdapter;
use Hyperf\Kafka\Producer;

#[Command]
class TestConnections extends HyperfCommand
{
    /**
     * The command
     *
     * @var string
     */
    protected ?string $name = 'checkConnection';


    public function handle(): void
    {
        $this->line('Проверка сервисов', 'info');
        $this->TestPostgresql();
        $this->TestClickHouse();
        $this->TestMongoDB();
        $this->TestRedis();
        $this->TestKafka();
        $this->TestMinio();
        $this->TestRabbitMQ();
    }

    private function TestPostgresql(): void
    {
        try {
            Db::select('SELECT 1');

            $this->line("connection to postgresql - ok!", 'info');
        } catch (\Throwable $e) {
            $this->line("connection to postgresql - error:" . $e->getMessage(), 'error');
        }
    }

    private function TestClickHouse(): void
    {
        try {
            $config = [
                'host' => env('CLICKHOUSE_HOST'),
                'port' => env('CLICKHOUSE_PORT'),
                'username' => env('CLICKHOUSE_USER'),
                'password' => env('CLICKHOUSE_PASSWORD'),
                'https' => env('CLICKHOUSE_HTTPS')
            ];

            $db = new ClickHouseDB\Client($config);
            $db->database('default');
            $db->setTimeout(1.5);
            $db->setTimeout(10);
            $db->setConnectTimeOut(5);
            $db->ping(true);

            $this->line("connection to ClickHouseDB - ok!", 'info');
        } catch (\Throwable $e) {
            $this->line("connection to ClickHouseDB - error:" . $e->getMessage(), 'error');
        }
    }

    public function TestMongoDB(): void
    {
        $uri = 'mongodb://' . env('MONGODB_USER') . ':' . env('MONGODB_PASSWORD') . '@' . env('MONGODB_HOST') . ':' . env('MONGODB_PORT') . '/';
        $client = new Client($uri);
        try {
            $client->selectDatabase('admin')->command(['ping' => 1]);

            $this->line("connection to mongodb - ok!", 'info');
        } catch (Exception $e) {
            $this->line("connection to mongodb - error:" . $e->getMessage(), 'error');
        }
    }

    public function TestRedis(): void
    {
        try {
            $container = ApplicationContext::getContainer();
            $redis = $container->get(\Redis::class);

            $redis->keys('*');

            $this->line("connection to redis - ok!", 'info');
        } catch (Exception $e) {
            $this->line("connection to redis - error:" . $e->getMessage(), 'error');
        }
    }

    public function TestKafka(): void
    {
        try {
            $container = ApplicationContext::getContainer();
            $producer = $container->get(Producer::class);

            $v = rand(100, 999) . 'k';
            $producer->send('test', $v, 'key');

            $this->line("connection to kafka - ok!", 'info');
        } catch (Exception $e) {
            $this->line("connection to kafka - error:" . $e->getMessage(), 'error');
        }
    }

    public function TestRabbitMQ(): void
    {
        try {
            $connection = new AMQPStreamConnection(
                env('RABBITMQ_HOST'),
                5672,
//                env('RABBITMQ_PORT'),
                env('RABBITMQ_USER'),
                env('RABBITMQ_PASSWORD'));
            $channel = $connection->channel();
            $channel->close();
            $connection->close();
            $this->line("connection to rabbitmq - ok!", 'info');
        } catch (AMQPTimeoutException $e) {
            $this->line("connection to rabbitmq - error:" . $e->getMessage(), 'error');
        }
    }

    public function TestMinio(): void
    {
        \Swoole\Runtime::setHookFlags( SWOOLE_HOOK_ALL ^ SWOOLE_HOOK_CURL ^ SWOOLE_HOOK_NATIVE_CURL );
        $s3Client = new S3Client([
            'version' => 'latest',
            'region' => 'us-east-1',
            'endpoint' => env('MINIO_HOST') . ':'. env('MINIO_PORT'),
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key' => env('AWS_KEY'),
                'secret' => env('AWS_SECRET'),
            ],
        ]);

        try {
            $this->line("connection to minio - ok!", 'info');
        } catch (AwsException $e) {
            $this->line("connection to minio - error:" . $e->getMessage(), 'error');

        }
    }
}


