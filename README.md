# Google-Direction-Api

Require version of PHP >= 7.4

1.Run in terminal
	curl -sL https://deb.nodesource.com/setup_17.x -o /tmp/nodesource_setup.sh
	nano /tmp/nodesource_setup.sh
	sudo bash /tmp/nodesource_setup.sh
	sudo apt install nodejs
	node -v
	npm update

2. in 'composer.json' file add below code for elephant.io
       "require": {
	"wisembly/elephant.io": "^3.3",
	},

3. update composer using
       composer update

4. Start server using
	node server_local.js - For log 
	 Or using pm2 need to install pm2 npm
	pm2 start server_live.js 
	pm2 stop server_live.js


**For Development changes as below **

1. Using controller call socket for track order 

File Path : (trackorder/socket_data_send_to_emit)

2. Common Socket emit function use "Socket.php"
Also, add in top of page
	require_once(FCPATH . 'vendor/autoload.php');
	use ElephantIO\Client;
	use ElephantIO\Engine\SocketIO\Version2X;


3.Intialise your socket for realtime update in view file "index.php"

4.server_live.js in this file you need to create your socket with your unique name(Like : track_live_location)




