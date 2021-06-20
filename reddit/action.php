<?php

$memory = $this->botService->load_memory($bot_id);

if (!is_array($memory["last_posted"])) {
  if (empty($memory["last_posted"])) {
    $memory["last_posted"] = [];
  } else {
    $memory["last_posted"] = [$memory["last_posted"]];
  }
}

$simpleXml = simplexml_load_file($memory["url"], "SimpleXMLElement", LIBXML_NOCDATA);
$json = json_encode($simpleXml);
$data = json_decode($json, true);

if (!is_array($data["entry"]) || count($data["entry"]) == 0) {
  return;
}

$url = $data["entry"][0]["link"]["@attributes"]["href"];
$title = $data["entry"][0]["title"];
$content = $data["entry"][0]["content"];

$dom = new DOMDocument();
@$dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));

$images = $dom->getElementsByTagName('img');
if (count($images) > 0) {
  $image_url = $images[0]->getAttribute('src');
  $image = $this->botService->create_file_from_url($image_url);
}

if (
  in_array($url, $memory["last_posted"])
  || empty($url)
  || empty($title)
) {
  return;
}

$message = [
  "data" => [
    "text" => $url,
    "title" => $title,
    "no_embed" => !empty($image),
  ],
  "files" => empty($image) ? "" : [$image->getId()],
  "parent_id" => $memory["parent_id"] ?? "",
];

$this->botService->create_message($bot_id, $memory["group_id"], $message);

array_push($memory["last_posted"], $url);
if (count($memory["last_posted"]) > 10) {
  array_shift($memory["last_posted"]);
}

$this->botService->dump_memory($bot_id, $memory);
