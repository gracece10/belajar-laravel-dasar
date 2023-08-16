<?php

return [
    "author" => [
        "first" => env('NAME_FIRST',"Grace"), 
        //diambil dari environment variable, apabila di Name First tidak ada maka defaultnya atau yang ditampilkan adalah yang disebelahnya yaitu "Grace"
        // "first" => "Grace", 
        // "last" => "Amianie"
        "last" => env('NAME_LAST',"Amianie")
    ],
    "email" => "echo.gresce10@gmail.com",
    "web" => "https://www.programmerzamannow.com/"
];
