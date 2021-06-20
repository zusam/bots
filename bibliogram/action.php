<?php

$memory = $this->botService->load_memory($bot_id);

if (!is_array($memory["last_posted"])) {
  if (empty($memory["last_posted"])) {
    $memory["last_posted"] = [];
  } else {
    $memory["last_posted"] = [$memory["last_posted"]];
  }
}

$feed = file_get_contents($memory["instance"] . "/u/" . $memory["profile"] . "/atom.xml");
$xml = simplexml_load_string($feed);
$json = json_encode($xml);
$array = json_decode($json, true);

$post_id = substr($array["entry"][0]["id"], 16);

$post_url = $memory["instance"] . "/p/" . $post_id;

$dom = new DOMDocument();
@$dom->loadHTML(mb_convert_encoding(file_get_contents($post_url), 'HTML-ENTITIES', 'UTF-8'));

$images = $dom->getElementsByTagName('img');
foreach($images as $im) {
  if ($im->getAttribute('class') == "sized-image") {
    $image_url = $memory["instance"] . $im->getAttribute('src');
  }
}

$paragraphs = $dom->getElementsByTagName('p');
foreach($paragraphs as $p) {
  if ($p->getAttribute('class') == "structured-text description") {
    $text = $p->textContent;
  }
  if ($p->getAttribute('class') == "description") {
    $title = $p->textContent;
  }
}

$image = $this->botService->create_file_from_url($image_url);

if (
  in_array($post_id, $memory["last_posted"])
  || empty($post_id)
) {
  return;
}

$message = [
  "data" => [
    "text" => "https://www.instagram.com/p/$post_id\n\n" . $text,
    "title" => $title,
    "no_embed" => true
  ],
  "files" => [$image->getId()],
  "parent_id" => $memory["parent_id"] ?? "",
];

$this->botService->create_message($bot_id, $memory["group_id"], $message);

array_push($memory["last_posted"], $post_id);
if (count($memory["last_posted"]) > 10) {
  array_shift($memory["last_posted"]);
}

$this->botService->dump_memory($bot_id, $memory);
