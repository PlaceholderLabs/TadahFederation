<p align="center"><img src="https://tadah.rocks/images/logos/full.png" alt="Tadah Logo"/></p>

# Tadah User Federation PHP Api
This api allows for 3rd-parties to login to their site using Tadah as a Home Server.
 
This api is unofficial and might stop working randomly, but i will try to keep it working when i can.

# How it works
Tadah has no Federation support, so we use a hacky workaround using `POST` and `GET` requests to achieve this, however this will only work one way (Tadah->Your Site) since this wouldn't grant write access to the User.

To grab user info, the script will act as a normal browser and attempt to log in to Tadah, then fetches the info (such as equipped items, username, amount of currency, body colors)

However, Tadah uses Laravel so their login system is both easier and weird to program with.

Before processing user credentials, the API will fetch a CSRF token by `GET`'ing the login page (the CSRF is in an HTML form),
Then is `POST`'ed user credentials along with the CSRF token.

# Usage
Login(username, password) - logs into Tadah and returns the user's info as an `Array`.

# Example
```
<?php
require('tadah_federation.php');
$login = new tadah_federation();
$login_result = $login->Login("yourTadahEmail@tadah.rocks", "TadahAccountPassword");
echo "LOGIN RESULT: ".$login_result;
