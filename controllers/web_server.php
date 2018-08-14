<?php

/**
 * Web server controller.
 *
 * @category   apps
 * @package    web-server
 * @subpackage controllers
 * @author     ClearFoundation <developer@clearfoundation.com>
 * @copyright  2012 ClearFoundation
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/web_server/
 */

///////////////////////////////////////////////////////////////////////////////
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
///////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////
// C L A S S
///////////////////////////////////////////////////////////////////////////////

/**
 * Web server controller.
 *
 * @category   apps
 * @package    web-server
 * @subpackage controllers
 * @author     ClearFoundation <developer@clearfoundation.com>
 * @copyright  2012 ClearFoundation
 * @license    http://www.gnu.org/copyleft/gpl.html GNU General Public License version 3 or later
 * @link       http://www.clearfoundation.com/docs/developer/apps/web_server/
 */

class Web_Server extends ClearOS_Controller
{
    /**
     * Web server summary view.
     *
     * @return view
     */

    function index()
    {
        // Show account status widget if we're not in a happy state
        //---------------------------------------------------------

        $this->load->module('accounts/status');

        if ($this->status->unhappy()) {
            $this->status->widget('web_server');
            return;
        }

        // Show Certificate Manager widget if it is not initialized
        //---------------------------------------------------------

        $this->load->module('certificate_manager/certificate_status');

        if (! $this->certificate_status->is_initialized()) {
            $this->certificate_status->widget();
            return;
        }

        // Load libraries
        //---------------

        $this->lang->load('web_server');

        // Load views
        //-----------

        // $views = array('web_server/server', 'web_server/network', 'web_server/settings', 'web_server/sites', 'web_server/webapps');
        $views = array('web_server/server', 'web_server/settings', 'web_server/sites', 'web_server/webapps');

        $this->page->view_forms($views, lang('web_server_app_name'));
    }
}
