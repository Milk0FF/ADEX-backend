<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserInfo;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'executor' => [
                'username' => 'userreg1', 'email' => 'executor@executor.ru', 'password' => Hash::make('123456'), 'user_type_id' => 1
            ],
            'executorInfo' => [
                'firstName' => 'Иван', 'lastname' => 'Медведев', 'about' => 'Я лучший исполнитель!', 'phone' => '79549214567', 'city' => 'Самара', 'country' => 'Россия', 'birth_date' => new DateTime(), 'rating' => 2.00, 'employment_type_id' => 1
            ],
            'customer' => [
                'username' => 'userreg2', 'email' => 'customer@customer.ru', 'password' => Hash::make('123456'), 'user_type_id' => 2
            ],
            'customerInfo' => [
                'firstName' => 'Владимир', 'lastname' => 'Иванов', 'about' => 'Я лучший заказчик!', 'phone' => '79879659493', 'city' => 'Самара', 'country' => 'Россия', 'birth_date' => new DateTime(), 'rating' => 4.00, 'employment_type_id' => 1 ,
            ],
            'admin' => [
                'username' => 'userreg3', 'email' => 'admin@admin.ru', 'password' => Hash::make('admin'), 'user_type_id' => 3
            ],
            'adminInfo' => [
                'firstName' => 'Админ', 'lastname' => 'Админ', 'about' => 'Админ', 'phone' => '77777777777', 'city' => 'Москва', 'country' => 'Россия', 'birth_date' => new DateTime(), 'rating' => '0.00', 'employment_type_id' => 1,
            ],

            'executor2' => [
                'username' => 'userreg4', 'email' => 'test@test.ru', 'password' => Hash::make('123456'), 'user_type_id' => 1
            ],
            'executorInfo2' => [
                'firstName' => 'Владимир', 'lastname' => 'Иванов', 'about' => 'Я лучший заказчик!', 'phone' => '79432322332', 'city' => 'Омск', 'country' => 'Россия', 'birth_date' => new DateTime(), 'rating' => 10.00, 'employment_type_id' => 1 ,
            ],

            'customer2' => [
                'username' => 'userreg5', 'email' => 'customer@customer.ru', 'password' => Hash::make('123456'), 'user_type_id' => 2
            ],
            'customerInfo2' => [
                'firstName' => 'Владимир', 'lastname' => 'Иванов', 'about' => 'Я лучший заказчик!', 'phone' => '79879659493', 'city' => 'Самара', 'country' => 'Россия', 'birth_date' => new DateTime(), 'rating' => 4.00, 'employment_type_id' => 1 ,
            ],

            'executor3' => [
                'username' => 'userreg4', 'email' => 'customer@customer.ru', 'password' => Hash::make('123456'), 'user_type_id' => 2
            ],
            'executorInfo3' => [
                'firstName' => 'Владимир', 'lastname' => 'Иванов', 'about' => 'Я лучший заказчик!', 'phone' => '79879659493', 'city' => 'Самара', 'country' => 'Россия', 'birth_date' => new DateTime(), 'rating' => 4.00, 'employment_type_id' => 1 ,
            ],

            'customer3' => [
                'username' => 'userreg6', 'email' => 'customer@customer.ru', 'password' => Hash::make('123456'), 'user_type_id' => 2
            ],
            'customerInfo3' => [
                'firstName' => 'Владимир', 'lastname' => 'Иванов', 'about' => 'Я лучший заказчик!', 'phone' => '79879659493', 'city' => 'Самара', 'country' => 'Россия', 'birth_date' => new DateTime(), 'rating' => 4.00, 'employment_type_id' => 1 ,
            ],
        ];

        $currentExecutor =  User::create($data['executor']);
        $currentExecutorInfo = UserInfo::create($data['executorInfo']);
        $currentExecutor->user_info_id = $currentExecutorInfo->id;
        $currentExecutor->save();

        $currentCustomer =  User::create($data['customer']);
        $currentCustomerInfo = UserInfo::create($data['customerInfo']);
        $currentCustomer->user_info_id = $currentCustomerInfo->id;
        $currentCustomer->save();

        $admin =  User::create($data['admin']);
        $adminInfo = UserInfo::create($data['adminInfo']);
        $admin->user_info_id = $adminInfo->id;
        $admin->save();

    }
}
