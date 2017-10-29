<?php

use Aws\Sqs\SqsClient;

require_once __DIR__ . '/vendor/autoload.php';

(new \Symfony\Component\Dotenv\Dotenv())->load('.env');

$client = new SqsClient([
    'version' => 'latest',
    'region' => 'us-east-1',
    'credentials' => [
        'key' => getenv('AMAZON_SQS_KEY'),
        'secret' => getenv('AMAZON_SQS_SECRET'),
    ],
]);

while (true) {

    $response = $client->receiveMessage([
        'QueueUrl' => getenv('AMAZON_SQS_QUEUE_URL'),
        'AttributeNames' => ['ApproximateReceiveCount']
    ]);

    if (count($response['Messages']) > 0) {

        $queue_handle = $response['Messages'][0]['ReceiptHandle'];

        $message = json_decode($response['Messages'][0]['Body'], true);

        echo " [x] Received (Event ID)", $message['event_id'], "\n";

        sleep(rand(3, 6));

        $client->deleteMessage(array(
            'QueueUrl' => getenv('AMAZON_SQS_QUEUE_URL'),
            'ReceiptHandle' => $queue_handle
        ));
    }

}
