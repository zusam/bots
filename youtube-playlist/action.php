<?php

$memory = $this->botService->load_memory($bot_id);

if (!is_array($memory["last_posted"])) {
  if (empty($memory["last_posted"])) {
    $memory["last_posted"] = [];
  } else {
    $memory["last_posted"] = [$memory["last_posted"]];
  }
}

$url = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=10&playlistId="
        . $memory["upload_playlist_id"] . "&key=" . $memory["youtube_key"];

$data = json_decode(file_get_contents($url), true);

if (!is_array($data["items"]) || count($data["items"]) == 0) {
  return;
}

$video_id = $data["items"][0]["snippet"]["resourceId"]["videoId"];
$video_title = $data["items"][0]["snippet"]["title"];

if (
  in_array($video_id, $memory["last_posted"])
  || empty($video_id)
  || empty($video_title)
) {
  return;
}

$message = [
  "data" => [
    "text" => "https://www.youtube.com/watch?v=".$video_id,
    "title" => $video_title,
  ],
  "parent_id" => $memory["parent_id"] ?? "",
];

$this->botService->create_message($bot_id, $memory["group_id"], $message);

array_push($memory["last_posted"], $video_id);
if (count($memory["last_posted"]) > 10) {
  array_shift($memory["last_posted"]);
}

$this->botService->dump_memory($bot_id, $memory);
