Bibliogram
==========

<img src="avatar.png" width="150px"/>

This bot will relay posts of an instagram user using a chosen Bibliogram instance.
You'll need to choose an instance in [this list](https://git.sr.ht/~cadence/bibliogram-docs/tree/master/docs/Instances.md) and put the URL as value for `instance`. You'll also need to fill up the `profile` with the profile id of the user you want to get the posts.

You also need to specify the `group_id` where the bot is going to post (and eventually a `parent_id` if you want it's messages to be children of another message).  
`last_posted` is used internally to avoid duplicates.

The Bibliogram bot was tested with Zusam 0.4.5
