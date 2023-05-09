<?php

echo "Server Time: ".exec('date');

echo "<br />";

echo "PHP Time: ".date('r');

echo "<br />";

echo "Julian Day: ".str_pad((date('z')+1), 3, '0', STR_PAD_LEFT);
