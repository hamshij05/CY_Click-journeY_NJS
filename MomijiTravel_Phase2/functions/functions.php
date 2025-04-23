<?php

// Function to get all users data
function getAllUsers($filePath) {
    if (file_exists($filePath)) {
        $jsonData = file_get_contents($filePath);
        return json_decode($jsonData, true);
    }
    return ["users" => []];
}

// Get profile picture path
function getProfilePicture($userId) {
    $formats = ['jpg', 'jpeg', 'png'];
    foreach ($formats as $format) {
        $path = "assets/images/profil/profile_{$userId}.{$format}";
        if (file_exists($path)) {
            return $path;
        }
    }
    return 'assets/images/profil/profil.jpg';
}

// Function to extract region code from full name
function getRegionCode($fullName) {
    if (strpos($fullName, 'Kantō') !== false) return 'kanto';
    if (strpos($fullName, 'Kansai') !== false) return 'kansai';
    if (strpos($fullName, 'Tōhoku') !== false) return 'tohoku';
    return '';
}

// Function to extract theme code from full name
function getThemeCode($fullName) {
    if (strpos($fullName, 'Culture') !== false) return 'culture';
    if (strpos($fullName, 'Gastronomique') !== false) return 'gastronomique';
    if (strpos($fullName, 'Détente') !== false) return 'détente';
    return '';
}

function getAPIKey($vendeur)
{
	if(in_array($vendeur, array('MI-1_A', 'MI-1_B', 'MI-1_C', 'MI-1_D', 'MI-1_E', 'MI-1_F', 'MI-1_G', 'MI-1_H', 'MI-1_I', 'MI-1_J', 'MI-2_A', 'MI-2_B', 'MI-2_C', 'MI-2_D', 'MI-2_E', 'MI-2_F', 'MI-2_G', 'MI-2_H', 'MI-2_I', 'MI-2_J', 'MI-3_A', 'MI-3_B', 'MI-3_C', 'MI-3_D', 'MI-3_E', 'MI-3_F', 'MI-3_G', 'MI-3_H', 'MI-3_I', 'MI-3_J', 'MI-4_A', 'MI-4_B', 'MI-4_C', 'MI-4_D', 'MI-4_E', 'MI-4_F', 'MI-4_G', 'MI-4_H', 'MI-4_I', 'MI-4_J', 'MI-5_A', 'MI-5_B', 'MI-5_C', 'MI-5_D', 'MI-5_E', 'MI-5_F', 'MI-5_G', 'MI-5_H', 'MI-5_I', 'MI-5_J', 'MEF-1_A', 'MEF-1_B', 'MEF-1_C', 'MEF-1_D', 'MEF-1_E', 'MEF-1_F', 'MEF-1_G', 'MEF-1_H', 'MEF-1_I', 'MEF-1_J', 'MEF-2_A', 'MEF-2_B', 'MEF-2_C', 'MEF-2_D', 'MEF-2_E', 'MEF-2_F', 'MEF-2_G', 'MEF-2_H', 'MEF-2_I', 'MEF-2_J', 'MIM_A', 'MIM_B', 'MIM_C', 'MIM_D', 'MIM_E', 'MIM_F', 'MIM_G', 'MIM_H', 'MIM_I', 'MIM_J', 'SUPMECA_A', 'SUPMECA_B', 'SUPMECA_C', 'SUPMECA_D', 'SUPMECA_E', 'SUPMECA_F', 'SUPMECA_G', 'SUPMECA_H', 'SUPMECA_I', 'SUPMECA_J', 'TEST'))) {
		return substr(md5($vendeur), 1, 15);
	}
	return "zzzz";
}

// Function to verify credentials
function verifyCredentials($login, $password) {
    if (!file_exists('users.json')) {
        return ['error' => 'Erreur système, veuillez réessayer plus tard'];
    }

    $usersData = json_decode(file_get_contents('users.json'), true);
    foreach ($usersData['users'] as $user) {
        if ($user['login'] === $login) {
            if (password_verify($password, $user['password'])) {
                return ['success' => true, 'user' => $user];
            } else {
                return ['error' => 'Mot de passe incorrect'];
            }
        }
    }
    return ['error' => 'Identifiant non trouvé'];
}

// Function to update user data
function updateUserData($filePath, $userId, $userData) {
    $allUsers = getAllUsers($filePath);
    foreach ($allUsers['users'] as $key => $user) {
        if ($user['id'] === $userId) {
            $allUsers['users'][$key] = array_merge($user, $userData);
            break;
        }
    }
    return file_put_contents($filePath, json_encode($allUsers, JSON_PRETTY_PRINT));
}

// Function to get specific user data
function getUserData($filePath, $userId) {
    $allUsers = getAllUsers($filePath);
    foreach ($allUsers['users'] as $user) {
        if ($user['id'] === $userId) {
            return $user;
        }
    }
    return null;
}

// Function to get full theme name
function getThemeName($theme) {
    $themeNames = [
        'culture' => 'Culture & Temples',
        'gastronomique' => 'Gastronomique & Traditionnel',
        'détente' => 'Détente & Bien-être'
    ];
    return $themeNames[$theme] ?? $theme;
}

// Function to get full transport name
function getTransportName($transport) {
    $transportNames = [
        'vip' => 'Transport VIP',
        'standard' => 'Transport Standard'
    ];
    return $transportNames[$transport] ?? $transport;
}

// Function to get full hotel name
function getHotelName($hotel) {
    $hotelNames = [
        'vip' => 'Hotel VIP',
        'standard' => 'Hotel Standard'
    ];
    return $hotelNames[$hotel] ?? $hotel;
}

// Function to generate the price
function generatePrice($theme, $region, $duration = 5, $transport = 'standard', $hotel = 'standard') {
    $basePrice = 3500;
    if ($region == 'kansai') $basePrice += 200;
    if ($duration == 5) $basePrice = round($basePrice / 2);
    if ($transport == 'vip') $basePrice += 100;
    if ($hotel == 'vip') $basePrice += 150;
    return $basePrice;
}

// Function to validate email format
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to check if login exists
function isLoginExists($login) {
    $usersFile = file_get_contents('users.json');
    $usersData = json_decode($usersFile, true);
    foreach ($usersData['users'] as $user) {
        if ($user['login'] === $login) {
            return true;
        }
    }
    return false;
}

function getRegionName($region) {
    $regionNames = [
        'kanto' => 'Kanto (Tokyo et alentours)',
        'kansai' => 'Kansai (Kyoto, Osaka, Nara, Kobe)',
        'tohoku' => 'Tohoku (Nord du Japon)'
    ];
    return isset($regionNames[$region]) ? $regionNames[$region] : $region;
}



?>
