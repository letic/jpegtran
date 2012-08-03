<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Jpegtran gallery3 module installer
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
class jpegtran_installer {
  /**
   * This will run on install (only on the first time !)
   * If you want to re-run this function you need to delete the module
   * entry from the DB.
   */
  static function install() {
    module::set_version("jpegtran", 2);
    
    // Attempt to locate jpegtran
    if (is_file($path = exec('which jpegtran'))) {
      module::set_var("jpegtran", "path", $path);      
    } 
    // Run check_config to display an error if jpegtran needs to be configured
    jpegtran::check_config();
  }
  
  /**
   * Disable the configuration warning on uninstall
   */
  static function deactivate() {
    site_status::clear("jpegtran_configuration");
    // module::delete doesn't seems to do anything
    module::delete("jpegtran");
  }
}
