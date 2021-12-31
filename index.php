<?php

include 'vendor/autoload.php';

use Aws\S3\PostObjectV4;
use Aws\S3\S3Client;

const AUTH_LOGIN    = '';
const AUTH_PASSWORD = '';
const BUCKET        = '';
const PREFIX        = '';
$redirectUrl = 'http://localhost/index.php?success=1';

$client = new S3Client([
    'version'                 => 'latest',
    'signature'               => 'v4',
    'region'                  => 'ru-1',
    'endpoint'                => 'https://s3.selcdn.ru',
    'use_path_style_endpoint' => true,
    'credentials'             => [
        'key'    => AUTH_LOGIN,
        'secret' => AUTH_PASSWORD,
    ],
]);

$acl     = 'public-read';
$expires = '+1 year';

$formInputs = [
    'acl'                     => $acl,
    'key'                     => PREFIX . DIRECTORY_SEPARATOR . uniqid() . '-${filename}',
    'success_action_redirect' => $redirectUrl,
];

$options = [
    ['acl' => $acl],
    ['bucket' => BUCKET],
    ['starts-with', '$key', PREFIX],
    ['starts-with', '$content-Type', 'video/'],
//    ['content-length-range', 0, (20 * 1024 * 1024)],
    ['eq', '$success_action_redirect', $redirectUrl],
];

$postObject = new PostObjectV4($client, BUCKET, $formInputs, $options, $expires);
$attributes = $postObject->getFormAttributes();
$inputs     = $postObject->getFormInputs();
?>

<form action="<?= $attributes['action'] ?>" method="<?= $attributes['method'] ?>" enctype="multipart/form-data">
    <?php
    foreach ($inputs as $name => $value) {
        printf('<input type="hidden" name="%s" value="%s"/>' . PHP_EOL, $name, $value);
    }
    ?>
    <input type="file" name="file">
    <button type="submit" class="btn btn-success">Загрузить</button>
</form>
