<?php

$listalt = json_decode($dataaltads);
if (is_array($listalt)) {
    foreach ($item as $alt) {
        if (!(array_search($alt->id, $listalt) !== false)) {
            echo '<option value="' . $alt->id . '">' . $alt->name . '</option>';
        }
    }
}