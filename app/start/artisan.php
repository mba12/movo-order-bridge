<?php

Artisan::add(new ClearExpiredCouponsCommand);
Artisan::add(new RetryFailedIngramShippingCommand);
Artisan::add(new ViewsCommand);
Artisan::add(new DeployCommand);
Artisan::add(new CatCommand);
Artisan::add(new CreateInsertFromTableCommand);
Artisan::add(new CreateXMLParserFromTableCommand);

