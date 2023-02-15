<?php
// This file is part of VPL for Moodle - http://vpl.dis.ulpgc.es/
//
// VPL for Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// VPL for Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with VPL for Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Download required/initial files
 *
 * @package mod_vpl
 * @copyright 2012 Juan Carlos Rodríguez-del-Pino
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author Juan Carlos Rodríguez-del-Pino <jcrodriguez@dis.ulpgc.es>
 */

require_once(dirname(__FILE__).'/../../../config.php');
require_once(dirname(__FILE__).'/../locallib.php');
require_once(dirname(__FILE__).'/../vpl.class.php');

require_login();
$id = required_param( 'id', PARAM_INT );
try {
    $vpl = new mod_vpl( $id );
    $vpl->restrictions_check();
    if (! $vpl->is_visible()) {
        vpl_redirect( '?id=' . $id, get_string( 'notavailable' ) );
    } else {
        $filegroup = $vpl->get_required_fgm();
        $filegroup->download_files( $vpl->get_name() );
    }
    die();
} catch ( Exception $e ) {
    vpl_redirect('?id=' . $id, $e->getMessage(), 'error' );
}
