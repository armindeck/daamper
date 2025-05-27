<?php
foreach (["post", "post/entries", "user", "draft"] as $value) {
    SCRIPTS->CrearCarpetas("database/$value/");
}