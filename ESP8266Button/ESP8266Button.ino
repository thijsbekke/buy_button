#include <ESP8266WiFi.h>

const char* ssid = "ssid";
const char* password = "pasword";

const char* host = "host.gateway.com";
const int httpPort = 80;
// This is de default url my gateway uses
String url = "/buy_button/gateway/order.php";
int pressed = false;
unsigned long startTime;

#define BUTTONPIN 2
#define LEDPIN 3
#define SEND_INTERVAL  1000 * 5// 30S 

void setup() {

  //Starting up
  delay(10);
  
  // prepare GPIO2
  pinMode(BUTTONPIN, INPUT_PULLUP);

  //Start wifi
  WiFi.begin(ssid, password);
  
  while (WiFi.status() != WL_CONNECTED) {
    //Wait for wifi too connect
    delay(500);
  }

  startTime = millis()+SEND_INTERVAL;
  // Starting loop, good luck
}

void loop() {

  int buttonState = digitalRead(BUTTONPIN);

  if (buttonState == LOW && pressed == false) {
    //  Button is pressed, save it so it don't fire this event again.
    pressed = true;
    ButtonPress();
  }
}


void ButtonPress() {
     
  // Use WiFiClient class to create TCP connections
  WiFiClient client;
  
  if (!client.connect(host, httpPort)) {
    // If client can't connect reset var, so you can try again.
    pressed = false;
    return;
  }
      
  // We now create a URI for the request
  // This will send the request to the server
  client.print(String("GET ") + url + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" + 
               "Connection: close\r\n\r\n");
  delay(10);

  //Reset var to be able to use the button again
  pressed = false;

  delay(500);
}

