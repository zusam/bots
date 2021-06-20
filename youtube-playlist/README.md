Youtube-playlist
================

![youtube logo](avatar.png)  

This bot will relay new videos from a youtube playlist.  
This can be used to relay videos from a youtube channel via their upload's playlist (You can get the id of such a playlist with the request `https://www.googleapis.com/youtube/v3/channels?part=contentDetails&forUsername=<channel_name>&key=<api_key>`).  
To work properly, this bot needs the id of a playlist under `upload_playlist_id` and a youtube api key under `youtube_key`.

You also need to specify the `group_id` where the bot is going to post (and eventually a `parent_id` if you want it's messages to be children of another message).  
`last_posted` is used internally to avoid duplicates.

The youtube-playlist bot was tested with Zusam 0.4.5
