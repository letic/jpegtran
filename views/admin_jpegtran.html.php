<?php defined("SYSPATH") or die("No direct script access.") ?>
<?php 
/**
 * Jpegtran gallery3 module admin page template
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
 ?>
<?= $theme->css("jquery.autocomplete.css") ?>
<?= $theme->script("jquery.autocomplete.js") ?>
<script type="text/javascript">
$("document").ready(function() {
  $("#g-path").gallery_autocomplete(
    "<?= url::site("__ARGS__") ?>".replace("__ARGS__", "admin/jpegtran/autocomplete"),
    {
      max: 256,
      loadingClass: "g-loading-small",
    });
});
</script>

<div class="g-block">
  <h1> <?= t("Jpegtran") ?> </h1>
  <div class="g-block-content">
    <p>
      <?= t("Jpegtran is a lossless tool provided by libjpeg that is able to rotate/optimise/resize images without any re-encoding.") ?>
    </p>
    <? if (! empty($system_path)): ?>
    <p>
      <?= t("Jpegtran has been found in $system_path. You can put a custom value below.") ?>
    </p>      
    <? else: ?>
    <p>
      <?= t("Jpegtran has not been detected on your system. Please enter its full path below :") ?>      
    </p>          
    <? endif ?>    
    <?= $form ?>
  </div>
</div>
