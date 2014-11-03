<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle. If not, see <http://www.gnu.org/licenses/>.

/**
 * Moodle/Totara LMS CPD plugin.
 *
 * A modern replacement for the legacy report_cpd module, which has numerous
 * security issues. Supports the existing tables without any fuss.
 *
 * @author Luke Carrier <luke@carrier.im> <luke@tdm.co>
 * @copyright 2014 Luke Carrier, The Development Manager Ltd
 * @license GPL v3
 */

namespace local_cpd\event;

use local_cpd\url_generator;
use local_cpd\util;

defined('MOODLE_INTERNAL') || die;

class year_deleted extends year_base {
    /**
     * @override \local_cpd\base_event
     */
    public static function get_name() {
        return util::string('event:yeardeleted');
    }

    /**
     * @override \local_cpd\base_event
     */
    protected function init() {
        parent::init();

        $this->data['crud'] = 'd';
    }

    /**
     * @override \local_cpd\base_event
     */
    public function get_description() {
        return util::string('event:yeardeleteddesc',
                            $this->get_description_subs());
    }

    /**
     * @override \local_cpd\base_event
     */
    public function get_legacy_logdata() {
        return array_merge(parent::get_legacy_logdata(), array(
            static::LEGACY_LOGDATA_ACTION => 'cpd year delete',
        ));
    }

    /**
     * @override \local_cpd\base_event
     */
    public function get_url() {
        return url_generator::delete_year($this->objectid);
    }
}
