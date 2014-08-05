<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

/* * ***************************Includes********************************* */
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

define('LIVENOTIFIERADDR', 'http://api.livenotifier.net/notify');

class livenotifier extends eqLogic {
    
}

class livenotifierCmd extends cmd {
    /*     * *************************Attributs****************************** */


    /*     * ***********************Methode static*************************** */


    /*     * *********************Methode d'instance************************* */

    public function preSave() {
        if ($this->getConfiguration('devid') == '') {
            throw new Exception('DevId ne peut etre vide');
        }
    }

    public function execute($_options = null) {
        if ($_options === null) {
            throw new Exception(__('Les options de la fonction ne peuvent etre null', __FILE__));
        }
        if ($_options['message'] == '' && $_options['title'] == '') {
            throw new Exception(__('Le message et le sujet ne peuvent être vide', __FILE__));
        }
        if ($_options['title'] == '') {
            $_options['title'] = __('[Jeedom] - Notification', __FILE__);
        }
        $url = LIVENOTIFIERADDR . '?apikey=' . trim($this->getConfiguration('devid')) . '&title=' . urlencode($_options['title']) . '&message=' . urlencode($_options['message']);
        $ch = curl_init($url);
        curl_exec($ch);
        curl_close($ch);
    }

    /*     * **********************Getteur Setteur*************************** */
}

?>