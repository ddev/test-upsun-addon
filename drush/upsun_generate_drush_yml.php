<?php

use Platformsh\ConfigReader\Config;

$config = new Config();
if (!$config->inRuntime()) {
  return;
}

$drushConfig = ['options' => ['uri' => $config->getRoute('main')['url']]];

$yaml = Symfony\Component\Yaml\Yaml::dump($drushConfig, 3, 2);
file_put_contents(getenv('PLATFORM_APP_DIR') . '/.drush/drush.yml', $yaml);