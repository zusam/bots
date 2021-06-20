<?php

$memory = $this->botService->load_memory($bot_id);
$apod_api_key = $memory["apod_api_key"];
$apod_data = json_decode(file_get_contents("https://api.nasa.gov/planetary/apod?api_key=$apod_api_key"), true);

$url = $apod_data['url'];
if (array_key_exists("hdurl", $apod_data)) {
  $url = $apod_data['hdurl'];
}

if (!is_array($memory["last_posted"])) {
  if (empty($memory["last_posted"])) {
    $memory["last_posted"] = [];
  } else {
    $memory["last_posted"] = [$memory["last_posted"]];
  }
}

$text = $apod_data["explanation"] . "\n" .  $url;
$title = $apod_data["title"];

if (
  in_array($url, $memory["last_posted"])
  || empty($url)
  || empty($title)
  || empty($apod_data["explanation"]
) {
  return;
}

$message = [
  "data" => [
    "text" => $text,
    "title" => $title,
  ],
  "parent_id" => $memory["parent_id"] ?? "",
];

$this->botService->create_message($bot_id, $memory["group_id"], $message);

array_push($memory["last_posted"], $url);
if (count($memory["last_posted"]) > 10) {
  array_shift($memory["last_posted"]);
}

$this->botService->dump_memory($bot_id, $memory);
