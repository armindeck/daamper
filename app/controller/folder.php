<?php
foreach (["post", "post/entries", "user", "draft"] as $value) {
    Daamper::$scripts->CrearCarpetas("database/$value/");
}