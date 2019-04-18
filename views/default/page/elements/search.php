<?php
$site_name = elgg_get_site_entity()->name;
$action = elgg_get_site_url() ."videos/youtube";

$htmlBody = <<<END
<form action="$action" method="GET">
  <div>
    <b><center>Search Videos:</center></b><br> <input type="search" id="q" name="q" placeholder="Search Videos">
  </div>
  <div>
    Results (max 10): <input type="number" id="maxResults" name="maxResults" min="1" max="10" step="1" value="5">
    <br><br>
   </div>
  <input type="submit" value="Search" class="elgg-button elgg-button-submit">
  <br><br>
</form>
END;

echo $htmlBody;
