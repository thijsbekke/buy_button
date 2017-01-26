# Buy Button
A Button that can buy things online. 

“It would be cool to have a physical button that when pressed it buys something at your web shop”. It has no functional use, nevertheless it was a fun weekend project. 

This button is based on an ESP8266 and a "gateway" written in PHP. The ESP8266 connects too the webserver which then connect trough their API.

## ESP8266
Inside the folder "ESP8266Button" there is the source code for the ESP8266, the wiring is [very simple](http://thedutchguys.com/wordpress/wp-content/uploads/2017/01/DSC_1861.png) just connect a push button the the GPIO2. For power I used a Li-Po from my drone as a power source, the Li-Po is 3.7v so I had to step it down with a voltage requlator (Pololu U1V10F3).

Don't forget too change the SSID and the Password to your WIFI credentials. Fun note; when I was programming this I forgot to end the while loop and accidentally created 100+ orders in a couple of seconds, oops.


## Gateway
Inside the folder "gateway" there is a simple PHP Script that connects too an API, gets a random product and creates an order with that product.
 
## STL
Inside the folder "stl" you will find the STL files for this button. The credits go too [rerofumi](http://www.thingiverse.com/rerofumi/about) which created the button. [http://www.thingiverse.com/thing:14887](http://www.thingiverse.com/thing:14887)

