<?php
require_once 'UserService.php';
require_once 'AccommodationService.php';

$userService = new UserService();
$accommodationService = new AccommodationService();

try {
    $userService->createUser([
        'firstName' => 'Sara',
        'lastName' => 'Smith',
        'email' => 'sara@example.com',
        'password' => 'securepass123',
        'phoneNumber' => '38761234567',
        'role' => 'user'
    ]);

    $accommodationService->createAccommodation([
        'name' => 'Ocean View Hotel',
        'location' => 'Dubrovnik',
        'pricePerNight' => 200,
        'category' => 'Hotel',
        'description' => 'Beautiful ocean view.',
        'imageUrls' => 'img1.jpg,img2.jpg'
    ]);

    print_r($userService->getAll());
    print_r($accommodationService->getAll());

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
