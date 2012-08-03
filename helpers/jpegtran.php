<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Jpegtran gallery3 module helper functions
 * 
 * Copyright (C) Anthony Callegaro
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 *-MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * A copy of the GPL2 License is available here :
 * http://www.gnu.org/licenses/gpl-2.0.html
 */
class jpegtran_Core {
  /**
   * Check if the module is configured and display a warning screen 
   *  if it isn't.
   */
  static function check_config($path=null) {
    if ($path === null) {
      $path = module::get_var("jpegtran", "path");
    }
    if (empty($path)) {
      // Display a permanent warning to configure the plugin
      site_status::warning(
        t("Jpegtran needs configuration. <a href=\"%url\">Configure it now!</a>",
          array("url" => html::mark_clean(url::site("admin/jpegtran")))),
        "jpegtran_configuration");
    } else {
      // Clear the warning
      site_status::clear("jpegtran_configuration");
    }
  }
}
