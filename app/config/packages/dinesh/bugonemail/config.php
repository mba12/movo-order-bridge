<?php

return array(
    'project_name' => 'Movo Orders',
    'notify_emails' => array('alex@jumpkick.pro','amelia@getmovo.com','michael@getmovo.com'),
    'email_template' => "bugonemail::email.notifyException",
    'notify_environment' => array( 'production'),
    'prevent_exception' => array('Symfony\Component\HttpKernel\Exception\NotFoundHttpException'),
);
