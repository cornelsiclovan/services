<?php

namespace App\DataFixtures;

use App\Entity\ClientSubService;
use App\Entity\Service;
use App\Entity\SubService;
use App\Entity\User;
use App\Entity\UserSubService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /** @var UserPasswordEncoderInterface  */
    private $passwordEncoder;

    /** @var  Factory */
    private $faker;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $this->loadServices($manager);
        $this->loadSubServices($manager);
        $this->loadUsers($manager);
        $this->loadUserSubServices($manager);
        $this->loadClientSubServices($manager);
    }

    public function loadServices(ObjectManager $manager)
    {
        $service = new Service();
        $service->setName("Electrical");
        $service->setDescription("Electrica instalation and service");

        $this->addReference('electrical_service', $service);

        $manager->persist($service);

        $service = new Service();
        $service->setName("Cleaning");
        $service->setDescription("Cleaning everithing");

        $this->addReference('cleaning', $service);

        $manager->persist($service);

        $manager->flush();
    }

    public function loadSubServices(ObjectManager $manager)
    {
        /** @var Service $service */
        $service = $this->getReference('electrical_service');

        // Electrical services
        // Subservice 1

        $subService = new SubService();
        $subService->setName("Outlets");
        $subService->setService($service);

        $this->setReference('outlets', $subService);

        $manager->persist($subService);

        // Electrical services
        // Subservice 2

        $subService = new SubService();
        $subService->setName("Cabling");
        $subService->setService($service);

        $this->setReference('cabling', $subService);

        $manager->persist($subService);

        // Electrical services
        // Subservice 3

        $subService = new SubService();
        $subService->setName("Lightswitch");
        $subService->setService($service);

        $this->setReference('lightswitch', $subService);

        $manager->persist($subService);

        // Cleaning services
        // Subservice 1

        /** @var Service $service */
        $service = $this->getReference('cleaning');

        $subService = new SubService();
        $subService->setName("Washing the floors");
        $subService->setService($service);

        $this->setReference('wash_floors', $subService);

        $manager->persist($subService);

        // Cleaning services
        // Subservice 2

        $subService = new SubService();
        $subService->setName("Washing the windows");
        $subService->setService($service);

        $this->setReference('wash_windows', $subService);

        $manager->persist($subService);

        // Cleaning services
        // Subservice 3

        $subService = new SubService();
        $subService->setName("Vacuuming the floors");
        $subService->setService($service);

        $this->setReference('vacuuming', $subService);

        $manager->persist($subService);

        $manager->flush();
    }

    public function loadUsers(ObjectManager $manager)
    {

        //First user Admin

        $user = new User();
        $user->setName("Siclovan");
        $user->setFirstName("Cornel");
        $user->setEmail("cornel.siclovan@gmail.com");
        $user->setTelephone($this->faker->phoneNumber);
        $user->setCountry("Romania");
        $user->setCity("Timisoara");
        $user->setStreet($this->faker->streetName);
        $user->setNumber($this->faker->numberBetween(0, 10));
        $user->setBuilding($this->faker->numberBetween(0, 10));
        $user->setStaircase($this->faker->numberBetween(0, 10));
        $user->setApartment($this->faker->numberBetween(0, 10));
        $user->setRoles(["ROLE_ADMIN"]);
        $user->setIsClient(false);
        $user->setIsServiceProvider(false);
        $user->setEnabled(true);

        $user->setPassword(
            $this->passwordEncoder->encodePassword($user,"Secret123#")
        );

        $this->addReference("user_admin", $user);

        $manager->persist($user);


        //Second user Service Provider

        $user = new User();
        $user->setName("Doe");
        $user->setFirstName("John");
        $user->setEmail("johndoe@gmail.com");
        $user->setTelephone($this->faker->phoneNumber);
        $user->setCountry("United States of America");
        $user->setCity($this->faker->city);
        $user->setStreet($this->faker->streetName);
        $user->setNumber($this->faker->numberBetween(0, 10));
        $user->setBuilding($this->faker->numberBetween(0, 10));
        $user->setStaircase($this->faker->numberBetween(0, 10));
        $user->setApartment($this->faker->numberBetween(0, 10));
        $user->setRoles(["ROLE_USER", "ROLE_SERVICE_PROVIDER"]);
        $user->setIsServiceProvider(true);
        $user->setIsClient(false);
        $user->setEnabled(true);

        $user->setPassword(
            $this->passwordEncoder->encodePassword($user,"Secret123#")
        );

        $this->addReference("user_service_provider", $user);

        $manager->persist($user);


        //Third user Client

        $user = new User();
        $user->setName("Rowling");
        $user->setFirstName("Jenny");
        $user->setEmail("jennyrowling@gmail.com");
        $user->setTelephone($this->faker->phoneNumber);
        $user->setCountry("United States of America");
        $user->setCity($this->faker->city);
        $user->setStreet($this->faker->streetName);
        $user->setNumber($this->faker->numberBetween(0, 10));
        $user->setBuilding($this->faker->numberBetween(0, 10));
        $user->setStaircase($this->faker->numberBetween(0, 10));
        $user->setApartment($this->faker->numberBetween(0, 10));
        $user->setRoles(["ROLE_USER", "ROLE_CLIENT"]);
        $user->setIsServiceProvider(false);
        $user->setIsClient(true);
        $user->setEnabled(true);


        $user->setPassword(
            $this->passwordEncoder->encodePassword($user,"Secret123#")
        );

        $this->addReference("user_client", $user);

        $manager->persist($user);

        //User number 4 - Client

        $user = new User();
        $user->setName("Solo");
        $user->setFirstName("Han");
        $user->setEmail("hansolo@gmail.com");
        $user->setTelephone($this->faker->phoneNumber);
        $user->setCountry("United States of America");
        $user->setCity($this->faker->city);
        $user->setStreet($this->faker->streetName);
        $user->setNumber($this->faker->numberBetween(0, 10));
        $user->setBuilding($this->faker->numberBetween(0, 10));
        $user->setStaircase($this->faker->numberBetween(0, 10));
        $user->setApartment($this->faker->numberBetween(0, 10));
        $user->setRoles(["ROLE_USER"]);
        $user->setIsServiceProvider(false);
        $user->setIsClient(true);
        $user->setEnabled(true);


        $user->setPassword(
            $this->passwordEncoder->encodePassword($user,"Secret123#")
        );

        $this->addReference("user_client_2", $user);

        $manager->persist($user);

        //User number 5 - Service Provider

        $user = new User();
        $user->setName("Ion");
        $user->setFirstName("Popescu");
        $user->setEmail("ionpopescu@gmail.com");
        $user->setTelephone($this->faker->phoneNumber);
        $user->setCountry("United States of America");
        $user->setCity($this->faker->city);
        $user->setStreet($this->faker->streetName);
        $user->setNumber($this->faker->numberBetween(0, 10));
        $user->setBuilding($this->faker->numberBetween(0, 10));
        $user->setStaircase($this->faker->numberBetween(0, 10));
        $user->setApartment($this->faker->numberBetween(0, 10));
        $user->setRoles(["ROLE_USER"]);
        $user->setIsServiceProvider(true);
        $user->setIsClient(false);
        $user->setEnabled(true);

        $user->setPassword(
            $this->passwordEncoder->encodePassword($user,"Secret123#")
        );

        $this->addReference("user_service_provider_2", $user);

        $manager->persist($user);

        $manager->flush();
    }

    public function loadClientSubServices(ObjectManager $manager)
    {
        // First Client - asking for electrical services

        /** @var User $user */
        $user = $this->getReference("user_client");

        /** @var Service $service */
        $service = $this->getReference("electrical_service");

        $clientSubService = new ClientSubService();
        $clientSubService->setUser($user);
        $clientSubService->setCity($user->getCity());
        $clientSubService->setCountry($user->getCountry());
        $clientSubService->setService($service);

        /** @var SubService $subService */
        $subService = $this->getReference("outlets");
        $clientSubService->addSubService($subService);

        /** @var SubService $subService */
        $subService = $this->getReference("lightswitch");
        $clientSubService->addSubService($subService);

        /** @var SubService $subService */
        $subService = $this->getReference("cabling");
        $clientSubService->addSubService($subService);

        $manager->persist($clientSubService);

        // Second client - is the same client as above asking for cleaning services

        /** @var User $user */
        $user = $this->getReference("user_client");

        /** @var Service $service */
        $service = $this->getReference("cleaning");

        $clientSubService = new ClientSubService();
        $clientSubService->setUser($user);
        $clientSubService->setCity($user->getCity());
        $clientSubService->setCountry($user->getCountry());
        $clientSubService->setService($service);

        /** @var SubService $subService */
        $subService = $this->getReference("wash_floors");
        $clientSubService->addSubService($subService);

        /** @var SubService $subService */
        $subService = $this->getReference("wash_windows");
        $clientSubService->addSubService($subService);

        /** @var SubService $subService */
        $subService = $this->getReference("vacuuming");
        $clientSubService->addSubService($subService);

        $manager->persist($clientSubService);

        // Third client - another client asking for cleaning

        /** @var User $user */
        $user = $this->getReference("user_client_2");

        /** @var Service $service */
        $service = $this->getReference("cleaning");

        $clientSubService = new ClientSubService();
        $clientSubService->setUser($user);
        $clientSubService->setCity($user->getCity());
        $clientSubService->setCountry($user->getCountry());
        $clientSubService->setService($service);

        /** @var SubService $subService */
        $subService = $this->getReference("wash_floors");
        $clientSubService->addSubService($subService);

        /** @var SubService $subService */
        $subService = $this->getReference("wash_windows");
        $clientSubService->addSubService($subService);

        /** @var SubService $subService */
        $subService = $this->getReference("vacuuming");
        $clientSubService->addSubService($subService);

        $manager->persist($clientSubService);


        $manager->flush();
    }

    public function loadUserSubServices(ObjectManager $manager)
    {
        // First UserSubService

        /** @var User $user */
        $user = $this->getReference("user_service_provider");

        /** @var Service $service */
        $service = $this->getReference("electrical_service");


        $userSubService = new UserSubService();
        $userSubService->setUser($user);
        $userSubService->setService($service);

        /** @var SubService $subService */
        $subService = $this->getReference("outlets");
        $userSubService->addSubService($subService);

        /** @var SubService $subService */
        $subService = $this->getReference("cabling");
        $userSubService->addSubService($subService);

        /** @var SubService $subService */
        $subService = $this->getReference("lightswitch");
        $userSubService->addSubService($subService);

        $manager->persist($userSubService);

        // Second UserSubService

        /** @var User $user */
        $user = $this->getReference("user_service_provider_2");

        /** @var Service $service */
        $service = $this->getReference("cleaning");


        $userSubService = new UserSubService();
        $userSubService->setUser($user);
        $userSubService->setService($service);

        /** @var SubService $subService */
        $subService = $this->getReference("wash_floors");
        $userSubService->addSubService($subService);

        /** @var SubService $subService */
        $subService = $this->getReference("wash_windows");
        $userSubService->addSubService($subService);

        /** @var SubService $subService */
        $subService = $this->getReference("vacuuming");
        $userSubService->addSubService($subService);

        $manager->persist($userSubService);


        $manager->flush();
    }
}
