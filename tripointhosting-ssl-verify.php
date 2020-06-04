<?php
/**
 * Plugin Name: tripointhosting-ssl-verify
 * Description: This plugin disables SSL verification when requesting against
                localhost, allowing the use of self-signed certificates with
                curl requests. This is useful for HTTP requests initiated
                from a server where the hostname resolves to 127.0.0.1,
                like from a cache preloader or cron job.

 * Author:      Byron DeLaMatre
 * License:     GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

// basic security, prevents file from being loaded directly.
defined( 'ABSPATH' ) or die( '&nbsp;' );

// https://developer.wordpress.org/reference/hooks/https_ssl_verify/
add_filter( 'https_ssl_verify', 'tripointhosting_disable_sslverify' );

/**
 * Returns true if REMOTE_ADDR is 127.0.0.1
 *
 * @return bool Boolean value TRUE
 */
function tripointhosting_disable_sslverify($verify_default) {

    $ssl_verify_whitelist = array(
        '127.0.0.1',
        '::1'
    );

    if(in_array($_SERVER['REMOTE_ADDR'], $ssl_verify_whitelist)){
        return false;
    }else{
        return $verify_default;
    }

}