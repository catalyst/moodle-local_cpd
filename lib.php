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

use local_cpd\util;

defined('MOODLE_INTERNAL') || die;

/**
 * Extend the site navigation
 *
 * @return void
 */
function local_cpd_extend_navigation(global_navigation $navroot) {
    if (!isloggedin()) {
        return;
    }

    $cpdurl = new moodle_url('/local/cpd/index.php');

    $navmy = $navroot->find('myprofile', navigation_node::TYPE_ROOTNODE);
    $navmy->add(util::string('mycpd'), $cpdurl,
                navigation_node::NODETYPE_LEAF, util::string('mycpd'),
                'local_cpd-my');

    // 2nd elem in this set:
    $navusers = $navroot->find_all_of_type(navigation_node::TYPE_USER);
    foreach ($navusers as $navuser) {
        if ($navuser->key !== 'myprofile') {
            $context = context_user::instance($navuser->key);
            if (!has_capability('local/cpd:viewuserreport', $context)) {
                continue;
            }

            $cpdurl->param('userid', $navuser->key);
            $navuser->add(util::string('cpd'), $cpdurl,
                          navigation_node::NODETYPE_LEAF, util::string('cpd'),
                          "local_cpd-{$navuser->key}");
        }
    }
}
