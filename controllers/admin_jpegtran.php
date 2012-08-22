<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Jpegtran gallery3 module admin page
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
class Admin_Jpegtran_Controller extends Admin_Controller {
  
  /**
   * Admin page index function
   */
  public function index() { 
    // Set page properties
    $view = new Admin_View("admin.html");
    $view->page_title = t("Jpegtran");
    $view->content = new View("admin_jpegtran.html");
    
    // Attempt to locate jpegtran
    if (is_file($path = exec('which jpegtran'))) {
      $view->content->system_path = $path;
    }
  
    // Get module parameters from the DB
    $view->content->path = module::get_var("jpegtran", "path");
    // First time run (no param in the DB)
    if (isset($view->content->path) && ! empty($path)) {
      // Add the located path in the DB
      module::set_var("jpegtran", "path", $path);
      $view->content->path = $path;
    } 
    // Add the form to the page
    $view->content->form = $this->_get_admin_form($view->content->path);
    // Display the page
    print $view;
  }
  
  /**
   * Server path autocomplete function
   */
  public function autocomplete() {
    $directories = array();

    $path_prefix = Input::instance()->get("q");
    foreach (glob("{$path_prefix}*") as $file) {
      // Filter only links. Display both directories and files
      if (!is_link($file)) {
        $directories[] = html::clean($file);
      }
    }

    ajax::response(implode("\n", $directories));
  }
  
  /**
   * Function called by the input form on button press
   */
  public function save() {
    access::verify_csrf();

    $form = $this->_get_admin_form();    
    if ($form->validate()) {
      $path = html_entity_decode($form->add_path->path->value);
      // Check the entered path
      if (is_link($path)) {
        $form->add_path->path->add_error("is_symlink", 1);
      } else if (!is_readable($path)) {
        $form->add_path->path->add_error("not_readable", 1);
      } else {
        // If the path is correct, save it to the DB
        module::set_var("jpegtran", "path", $path);
        message::success(t("Successfully saved %path", array("path" => $path)));
        jpegtran::check_config($path);
        url::redirect("admin/jpegtran");
      }
    }
    // In case of failure re-display the admin page
    $view = new Admin_View("admin.html");
    $view->page_title = t("Jpegtran");
    $view->content = new View("admin_jpegtran.html");
    
    $view->content->form = $form;
    print $view;
  }
  
  /**
   * Create the input form with the input box and save button 
   */
  private function _get_admin_form($path) {
    $form = new Forge("admin/jpegtran/save", "", "post",
                      array("id" => "g-jpegtran-admin-form", "class" => "g-short-form"));
    $add_path = $form->group("add_path");
    $add_path->input("path")
      ->label(t("Path"))
      ->rules("required")
      ->id("g-path")
      ->value($path)
      ->error_messages("not_readable", t("This file is not readable by the webserver"))
      ->error_messages("is_symlink", t("Symbolic links are not allowed"));
    $add_path->submit("save")->value(t("Save path"));

    return $form;
  }
}
?>
