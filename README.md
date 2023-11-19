# ᵔᴥᵔ LogIO-Devlog

[![Twitter Follow](https://img.shields.io/twitter/follow/davidbl.svg?style=social&label=Follow)](https://twitter.com/davidbl) [![GitHub issues](https://img.shields.io/github/issues/kawaiipantsu/logio-devlog.svg)](https://github.com/kawaiipantsu/logio-devlog/issues) [![GitHub closed issues](https://img.shields.io/github/issues-closed/kawaiipantsu/logio-devlog.svg)](https://github.com/kawaiipantsu/logio-devlog/issues) [![GitHub license](https://img.shields.io/github/license/kawaiipantsu/logio-devlog.svg)](https://github.com/kawaiipantsu/logio-devlog/blob/master/LICENSE) [![GitHub forks](https://img.shields.io/github/forks/kawaiipantsu/logio-devlog.svg)](https://github.com/kawaiipantsu/logio-devlog/network) [![GitHub stars](https://img.shields.io/github/stars/kawaiipantsu/logio-devlog.svg)](https://github.com/kawaiipantsu/logio-devlog/stargazers)
> A quick way to give yourself a "developer" real-time log from within your scripts, code or projects

![DevLog](assets/devlog-banner.png)

---

## Join the community

Join the community of Kawaiipantsu / THUGS(red) and participate in the dev talk around logio-devlog or simply just come visit us and chat about anything security related :) We love playing around with security. Also we have ctf events and small howto events for new players.

**THUGS(red) Discord**: <https://discord.gg/Xg2jMdvss9>

## First install & run LogIO server

This requires NodeJS / NPM. But the installation is very straight forward and easy.

```shell
apt update
apt install npm
npm install -g log.io
nano ~/.log.io/server.json
```

```ini
{
  "messageServer": { "port": 6689, "host": "127.0.0.1" },
  "httpServer": { "port": 6688, "host": "127.0.0.1" },
  "debug": false,
  "basicAuth": { "realm": "Devlog",
    "users": { "devlog": "devlog" }
  }
}
```
```shell
log.io-server
# Browse to http://localhost:6688
# Look in contrib for a systemd service file example
```

## How to use THUGSred logio-devlog

### PHP

```php
// Load it up!
require("devlog.inc.php");
$devlog = new Devlog(); // Localhost default
//$devlog = new Devlog("<remote-logio-ip-address>"); // Remember to also set the ip in the logio config

// Send a message :)
$devlog->sendMessage("My first message!!","Group1","Internal-function1");
$devlog->sendMessage("My second message!!","Group1","Internal-function2");
$devlog->sendMessage("My third message!!","Group2","Source1");
```
