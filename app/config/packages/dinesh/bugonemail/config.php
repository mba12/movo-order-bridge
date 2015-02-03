<?php

return array(
    'project_name' => 'Error on Movo production server!',
    'notify_emails' => array('alex@jumpkick.pro','amelia@getmovo.com','michael@getmovo.com', 'ryan@jumpkick.pro'),
    'email_template' => "bugonemail::email.notifyException",
    'notify_environment' => array( 'production'),
    'prevent_exception' => array(
        'Symfony\Component\HttpKernel\Exception\NotFoundHttpException'
    ),
);
