<?php
// Tadah User Federation PHP API (Unofficial)
// Created by PlaceholderLabs
// This is a hacky mess, but it works. (not really right now)


class tadah_federation
{
    // Login() - Logs into a Tadah account.
    // Takes 2 strings (Email and Password) and returns an array of information about the account.
    // REQUIRES A CSRF TOKEN! FOR SOME GOD DAMN REASON WE CAN'T STORE COOKIES AND GENERATE CSRF TOKENS WITHOUT LOGGING IN REAL-TIME!
    function Login($email, $password){
        /////////////// start of CSRF token fetching /////////////
        // Prepare to perform a GET request to https://tadah.rocks/login then fetch _token in the HTML form
        $ch = curl_init();


        curl_setopt($ch, CURLOPT_URL, "https://tadah.rocks/login");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // custom user agent so Tadah staff/server doesn't block us or IP poison us
        curl_setopt($ch, CURLOPT_USERAGENT, 'cURL/TadahFederation v1 - github.com/PlaceholderLabs/TadahFederation');


        // fetch the site's HTML
        $csrf_html = curl_exec($ch);

        // find the CSRF token in the HTML
        // TODO: prepare this for Tadah rewrite if login HTML changes!
        $pattern = '/<input type="hidden" name="_token" value="(.*?)"/';
        preg_match($pattern, $csrf_html, $matches);


        /////////////// end of CSRF token fetching ///////////////

        /////////////// start of login request ///////////////
        // prepare to perform a POST request to https://tadah.rocks/login
        echo $email."\n";
        echo $password."\n";
        echo $matches[1]."\n";


        curl_setopt($ch, CURLOPT_URL, 'https://tadah.rocks/login');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // POST the data
        curl_setopt($ch, CURLOPT_POST, 1);


        // include the CSRF token
        //curl_setopt($ch, CURLOPT_POSTFIELDS, '_token=r8YHSt4LDyVUmNXgFeHrMzRiDJpLaH8IdGvYBM7R'.'&email='.$email.'&password='.$password);
        curl_setopt_array($ch, array(
            CURLOPT_POSTFIELDS => array(
                '_token' => $matches[1],
                'email' => $email,
                'password' => $password
            )
        ));

        // custom user agent so Tadah staff/server doesn't block us or IP poison us
        curl_setopt($ch, CURLOPT_USERAGENT, 'cURL/TadahFederation v1 - github.com/PlaceholderLabs/TadahFederation');

        $login_result = curl_exec($ch);
        /////////////// end of login request ///////////////


        /////////////// start of account info fetching ///////////////
        // Attempt to visit the dashboard, now that we're logged in (this should tell us info like our username, and if we're banned)
        curl_setopt($ch, CURLOPT_URL, 'https://tadah.rocks/my/dashboard');

        // disable POST, we're not sending any data anymore
        curl_setopt($ch, CURLOPT_POST, 0);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // fetch the site's HTML
        $result = curl_exec($ch);
        curl_close($ch);
        /////////////// end of account info fetching ///////////////


        // return results
        return $login_result;
    }
}