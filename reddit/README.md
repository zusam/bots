Reddit
======

![reddit logo](avatar.png)  

This bot will post the first entry in the reddit rss feed given as `url`.  
This comes handy to post the top weekly of a subreddit for example (like https://www.reddit.com/r/worldnews/top.rss?t=weekly&sort=top).

You also need to specify the `group_id` where the bot is going to post (and eventually a `parent_id` if you want it's messages to be children of another message).  
`last_posted` is used internally to avoid duplicates.

The reddit bot was tested with Zusam 0.4.5
