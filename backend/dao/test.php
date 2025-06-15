<?php
require_once 'UserDao.php';
require_once 'AccommodationDao.php';

$userDao = new UserDao();
$accommodationDao = new AccommodationDao();

$userDao->insert([
    'firstName' => 'Test',
    'lastName' => 'User',
    'email' => 'test@example.com',
    'password' => password_hash('secret', PASSWORD_BCRYPT),
    'phoneNumber' => '1234567890',
    'role' => 'user'
]);

$accommodationDao->insert([
    'name' => 'Test Resort',
    'location' => 'Sarajevo',
    'pricePerNight' => 150,
    'category' => 'Resort',
    'description' => 'Test description',
    'imageUrls' => 'image1.jpg,image2.jpg'
]);

print_r($userDao->getAll());
print_r($accommodationDao->getAll());
?>
