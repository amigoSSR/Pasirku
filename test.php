<?php
Auth::loginUsingId(22);
$req = Request::create('/stokPasir/data', 'GET');
echo app()->handle($req)->getContent();
