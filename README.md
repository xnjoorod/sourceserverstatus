# Source Server Status
This repository stands for server status made based off SourceQuery, dynamically defined by a JSON file that loads the IP addresses, the ports and the names defined for servers.

Demo: http://www.drakz.pt/serverstatus

Any code optimizations are welcome for it to get more complete.

Credits
===
MaterializeCSS - http://materializecss.com

PHP SourceQuery by xPaw - https://github.com/xPaw/PHP-Source-Query

Installation
===

In order of installing this project, you must copy the files to the place you want and then change the servers listing on **servers.json**.

The server format must be:
```json
{
  "ID": [
    "IP address",
    "Server Port",
    "Alias (if wanted)"
  ]
}
```

Multiple servers can be set by separating arrays (defined by [ ]) with commas.

Todo
===
- Add an installation system
- Make it dynamic through SQL
- Add more customization options
