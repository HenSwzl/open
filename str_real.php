<?php
    class a {
        function get_str($str, $start, $end) {
            echo substr($str, strlen($start)+strpos($str, $start),(strlen($str) - strpos($str, $end))*(-1));
        }
    }
    $a = 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEASABIAAD/2wBDAAkGB';
    $b = new a();
    $b->get_str($a, '/', ';');
