# The Bear - a giant downloader - web front end to aria2

This is a fork of "The Bear - a giant downloader"
you find the original project here: http://sourceforge.net/projects/thebear/

I just forked the project because I could not reach the developer. I would like to
contribute the changes to the original project. So if you are the developer please 
send me a [message](http://www.individual-it.net/en/kontakt-impressum.html)

## Copyright (C) 2011 Behdad Kh.

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

https://github.com/individual-it/TheBearFork
Original source: 
http://sourceforge.net/projects/thebear/
 
## Changelog

### Fork of Release 1.0.1

* automaticly adds URL that is pased by $_GET['url']
	
* setting for auto-pause public users downloads if the file is bigger than certain size

* posibility to forbid the public users to Un-Pause downloads
	
* propper check for permissions, not just hiding controls
 
### Release 1.0.1

* some minor bug fixing
 
## Installation notes:

1. Just make sure protected/ and assets/ directories are writable/owned by the web server

2. Default configuration assumes that aria2 and The Bear are hosted on same server, 
   please change the host and port if aria2 is running some where else
   
3. Default RPC User and Pass for aria2 are user/pass, 
   set them empty if your aria2 doesn't require authentication for RPC connections (which is not recommended)
   
4. For the simplest way of running aria2 as a background process on Linux, one may executes this command:
   "nohup /usr/local/bin/aria2c --enable-rpc=true --rpc-listen-port=6800 --rpc-listen-all=true --dir=/home/USER/downloads --log=/home/USER/aria.log --log-level=error --dht-listen-port=6801 --rpc-user=user --rpc-passwd=pass -D"
   Please replace USER with your Linux username and check if your aria2 execution path is the same as above

## Other notes:

1. The Bear is written by PHP 5.3.3

2. aria2's version of the time of developing is 1.12.1 on Debian Squeeze (www.debian.org)
   This is the output of the aria2 version:
	    aria2 version 1.12.1
		Copyright (C) 2006, 2011 Tatsuhiro Tsujikawa

		This program is free software; you can redistribute it and/or modify
		it under the terms of the GNU General Public License as published by
		the Free Software Foundation; either version 2 of the License, or
		(at your option) any later version.

		This program is distributed in the hope that it will be useful,
		but WITHOUT ANY WARRANTY; without even the implied warranty of
		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
		GNU General Public License for more details.

		** Configuration **
		Enabled Features: Async DNS, BitTorrent, Firefox3 Cookie, GZip, HTTPS, Message Digest, Metalink, XML-RPC
		Hash Algorithms: sha-1, sha-224, sha-256, sha-384, sha-512, md5

		Report bugs to t-tujikawa@users.sourceforge.net
		Visit http://aria2.sourceforge.net/

3. The icons were taken from http://www.famfamfam.com/

4. Please report any bugs/suggestions via https://github.com/individual-it/TheBearFork/issues



