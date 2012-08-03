<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Jpegtran gallery3 module gallery_graphics_core overloading
 * 
 * Copyright (C) Carl Streeter, Anthony Callegaro
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
class gallery_graphics extends gallery_graphics_Core {
  
  /**
   * Rotate an image.  Valid options are degrees
   *
   * @param string     $input_file
   * @param string     $output_file
   * @param array      $options
   */
  static function rotate($input_file, $output_file, $options) {
    graphics::init_toolkit();

    module::event("graphics_rotate", $input_file, $output_file, $options);

    // Convert degrees for jpegtran specific format
    $jt_degrees = $options["degrees"];
    if ($jt_degrees < 0) {
      $jt_degrees += 360;
    }
    // Get path from the DB
    $path = module::get_var("jpegtran", "path");
    // Try to run jpegtran and falls back to the default if it fails
    if($error = exec($path.' -rot '.escapeshellarg($jt_degrees).' -outfile '.escapeshellarg($output_file).' -copy all '.escapeshellarg($input_file)))
    {
      Image::factory($input_file)
        ->quality(module::get_var("gallery", "image_quality"))
        ->rotate($options["degrees"])
        ->save($output_file);
    }

    module::event("graphics_rotate_completed", $input_file, $output_file, $options);
  }
}
