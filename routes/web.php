<?php

//默认路由

Route::get('/', function () {
    return redirect()->to("http://backstage/m/");
});




Auth::routes();

