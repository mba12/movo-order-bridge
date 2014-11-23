<?php
namespace Movo\Observer;

interface Subject {
    /**
     * @param Observer $observer
     * @return mixed
     */
    public function attach($observable);

    /**
     * @param Observer $observer
     * @return mixed
     */
    public function detach($index);

    /**
     * @param Observer $observer
     * @return mixed
     */
    public function notify($data);
}