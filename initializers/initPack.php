<?php
namespace UPhp\ActiveRecord\Initializers;

use UPhp\Languages\Label;
use UPhp\web\Application as App;

Label::addType(App::$appConfig["models"]);