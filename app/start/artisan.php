<?php

Artisan::add(new ClearExpiredCouponsCommand);
Artisan::add(new RetryFailedIngramShippingCommand);
Artisan::add(new ViewsCommand);
Artisan::add(new DeployCommand);

