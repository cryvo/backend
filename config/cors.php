<?php
return [
  'paths' => ['api/*'],
  'allowed_methods'   => ['*'],
  'allowed_origins'   => ['https://app.cryvo.io','exp+https://your-expo-app.io'],
  'allowed_headers'   => ['*'],
  'supports_credentials' => true,
];
