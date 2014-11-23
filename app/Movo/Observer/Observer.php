<?php
namespace Movo\Observer;

interface Observer
{
    public function handleNotification($data);
}