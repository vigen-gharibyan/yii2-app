<?php

namespace console\controllers;

use common\models\Category;
use yii\console\Controller;
use common\models\User;
use common\models\Settings;
use common\models\Lang;

class SeedController extends Controller
{
    public function actionIndex()
    {
        $this->createUsers();
        $this->createSettings();
        $this->createLanguages();
        $this->createCategories();
    }

    protected function createUsers()
    {
        $faker = \Faker\Factory::create();

        $items = [
            [
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => 'adminadmin',
                'role' => User::ROLE_ADMIN,
                'status' => User::STATUS_ACTIVE,
            ],
            [
                'username' => 'demo',
                'email' => 'demo@example.com',
                'password' => 'demodemo',
                'role' => User::ROLE_MODERATOR,
                'status' => User::STATUS_ACTIVE,
            ],
            [
                'username' => 'user1',
                'email' => 'user1@example.com',
                'password' => '11111111',
                'role' => User::ROLE_USER,
                'status' => User::STATUS_ACTIVE,
            ],
            [
                'username' => 'worker1',
                'email' => 'worker1@example.com',
                'password' => '11111111',
                'role' => User::ROLE_WORKER,
                'status' => User::STATUS_ACTIVE,
            ],
        ];

        $model = new User();
        foreach ($items as $item) {
            $model->setIsNewRecord(true);

            $model->id = NULL;
            $model->username = $item['username'];
            $model->email = $item['email'];
            $model->setPassword($item['password']);
            $model->role = $item['role'];
            $model->status = $item['status'];
            if ($model->save()) {
                //
            }
        }
    }

    protected function createSettings()
    {
        $model = new Settings();
        $model->setIsNewRecord(true);

        $model->id = NULL;
        $model->key = 'theme';
        $model->value = 'default';
        if ($model->save()) {
            //
        }

    }

    protected function createLanguages()
    {
        $items = [
            'en' => [
                'id' => NULL,
                'code' => 'en',
                'local' => 'en-En',
                'name' => 'English',
                'enabled' => Lang::STATUS_ACTIVE,
                'order' => 1,
            ],
            'ru' => [
                'id' => NULL,
                'code' => 'ru',
                'local' => 'ru-Ru',
                'name' => 'Russian',
                'order' => 2,
                'enabled' => Lang::STATUS_ACTIVE,
            ],
            'am' => [
                'id' => NULL,
                'code' => 'am',
                'local' => 'am-Am',
                'name' => 'Armenian',
                'order' => 3,
                'enabled' => Lang::STATUS_ACTIVE,
            ],
            'it' => [
                'id' => NULL,
                'code' => 'it',
                'local' => 'it-It',
                'name' => 'Italian',
                'order' => 4,
                'enabled' => Lang::STATUS_INACTIVE,
            ],
            'ro' => [
                'id' => NULL,
                'code' => 'ro',
                'local' => 'ro-Ro',
                'name' => 'Romania',
                'order' => 5,
                'enabled' => Lang::STATUS_INACTIVE,
            ],
        ];

        $model = new Lang();
        foreach ($items as $item) {
            $model->setIsNewRecord(true);

            foreach ($item as $attribute => $value) {
                $model->$attribute = $value;
            }

            if ($model->save()) {
                //
            }
        }
    }

    protected function createCategories()
    {
        $items = [
            [
                'id' => NULL,
                'name' => 'Category1',
            //    'name_ru' => 'Категория1',
            //    'name_am' => 'Կատեգորիա1',
                'description' => 'Description of Category1 ...',
            //    'description_ru' => 'Описание категории1 ...',
            //    'description_am' => 'Կատեգորիա1-ի նկարագրությունը ...',
                'enabled' => Category::STATUS_ACTIVE,
            ],
            [
                'id' => NULL,
                'name' => 'Category2',
                'description' => 'Description of Category2 ...',
                'enabled' => Category::STATUS_ACTIVE,
            ],
            [
                'id' => NULL,
                'name' => 'Category3',
                'description' => 'Description of Category3 ...',
                'enabled' => Category::STATUS_ACTIVE,
            ],
            [
                'id' => NULL,
                'name' => 'Category4',
                'description' => 'Description of Category4 ...',
                'enabled' => Category::STATUS_ACTIVE,
            ],
        ];

        $model = new Category();
        foreach ($items as $item) {
            $model->setIsNewRecord(true);

            foreach ($item as $attribute => $value) {
                $model->$attribute = $value;
            }

            if ($model->save()) {
                //
            }
        }
    }
}