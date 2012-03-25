<?php

/**
 * OpenReviewScript
 *
 * An Open Source Review Site Script
 *
 * @package		OpenReviewScript
 * @subpackage          site
 * @author		OpenReviewScript.org
 * @copyright           Copyright (c) 2011-2012, OpenReviewScript.org
 * @license		This file is part of OpenReviewScript - free software licensed under the GNU General Public License version 2 - http://OpenReviewScript.org/license
 * @link		http://OpenReviewScript.org
 */
// ------------------------------------------------------------------------

/**    This file is part of OpenReviewScript.
 *
 *    OpenReviewScript is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation, either version 2 of the License, or
 *    (at your option) any later version.
 *
 *    OpenReviewScript is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with OpenReviewScript.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Maintenance model class
 *
 * @package		OpenReviewScript
 * @subpackage          site
 * @category            model
 * @author		OpenReviewScript.org
 * @link		http://OpenReviewScript.org
 */
class Maintenance_model extends CI_Model {

    /*
     * Maintenance model class constructor
     */

    function Maintenance_model() {
	parent::__construct();
	$this->load->database();
    }

    /*
     * deleteSessions function
     */

    function deleteSessions($session_id='') {
	// delete all session records in the session table
	if ($session_id!=='') {
	    // except current session!
	    $this->db->where('session_id !=',$session_id);
	}
	$this->db->delete('session');
    }
}

/* End of file maintenance_model.php */
/* Location: ./application/models/maintenance_model.php */