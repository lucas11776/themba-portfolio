<?php

spl_autoload_register(function ($class) {
  $class = explode('\\', $class);
  $class = implode('/', $class);
  include $class . '.php';
});
