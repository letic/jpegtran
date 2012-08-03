<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Jpegtran gallery3 module admin menu
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
class jpegtran_event_Core {
  /**
   * Overload the admin_menu event to add jpegtran admin page in the
   *  settings submenu 
   */
  static function admin_menu($menu, $theme) {
    $menu->get("settings_menu")
      ->append(
        Menu::factory("link")
        ->id("jpegtran")
        ->label(t("Jpegtran"))
        ->url(url::site("admin/jpegtran")));
  }
}
