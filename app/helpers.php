<?php

// function Refgenerate($table, $prefix, $key)
// {
//     // Récupérer le dernier enregistrement de la table
//     $latest = $table::orderBy('id', 'desc')->first();
    
//     // Si aucun enregistrement n'existe, retourner le format initial
//     if (!$latest || !isset($latest->$key)) {
//         return $prefix . '-00001';
//     }
    
//     // Extraire la partie numérique du code
//     $number = preg_replace("/[^0-9]/", '', $latest->$key);
    
//     // Si aucune partie numérique n'est trouvée, commencer à 1
//     if (empty($number)) {
//         $number = 0;
//     }
    
//     // Générer le prochain code avec un format à 5 chiffres
//     return $prefix . '-' . sprintf('%05d', $number + 1);
// }

// function RefgenerateCode($table, $init, $key)
// {
//     $latest = $table::orderBy('idrdv', 'desc')->first();
//     if (!$latest) {
//         $code = $init . strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3)) . rand(10, 99);
//         return $code;
//     }

//     $string = preg_replace("/[^0-9\.]/", '', $latest->$key);
//     $code = $init . strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3)) . rand(10, 99);
//     return $code;
// }

// function RefgenerateCodePrest($table, $init, $key)
// {
//     $latest = $table::orderBy('id', 'desc')->first();
//     if (!$latest) {
//         $code = $init . strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3)) . rand(10, 99);
//         return $code;
//     }

//     $string = preg_replace("/[^0-9\.]/", '', $latest->$key);
//     $code = $init . strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3)) . rand(10, 99);
//     return $code;
// } 

// function RefgenerateOTP($table, $key)
// {
//     $latest = $table::orderBy('id', 'desc')->first();
//     if (!$latest) {
//         $code = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6);
//         return $code;
//     }

//     $string = preg_replace("/[^0-9\.]/", '', $latest->$key);
//     $code = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6);

    
//     return $code;
// }


?>