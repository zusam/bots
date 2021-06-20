Zusam bots
==========

This repository stores some bot examples that you can use right now.  
Please make sure to check the `README.md` for each bot to know the specifics.

The general procedure to use a bot is the following:
1. Activate bot usage by setting `ALLOW_BOTS` to `true` in your `config` file.
2. Create a `bots` directory in your `data` directory.
3. Copy the desired bot (it's entire directory) to the `bots` directory.
4. Adjust the `memory.json` file according to the bots `README.md`.
5. Make sure that the bots directories are readable by the backend (`chmod 755 -R bots/`)

Bots were introduced in Zusam `0.4.5`. It is possible that subsequent Zusam versions will change the bot callable functions.  
Make sure that the bot was tested with your version (or test it yourself and report issues here).

I will make sure to review all bots that are pushed to this repository.  
But be aware that untrusted bots can lead to security issues (that's why they're disabled by default).
