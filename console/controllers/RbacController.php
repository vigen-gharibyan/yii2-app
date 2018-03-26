<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\components\rbac\UserRoleRule;
use common\components\rbac\PostAuthorRule;
use common\components\rbac\ProfileAuthorRule;
use common\components\rbac\EstateAuthorRule;
use common\components\rbac\WorkerSettingsAuthorRule;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll(); //удаляем старые данные

        //Включаем наш обработчик
        $rule = new UserRoleRule();
        $postAuthorRule = new PostAuthorRule();
        $profileAuthorRule = new ProfileAuthorRule();
        $estateAuthorRule = new EstateAuthorRule();
        $workerSettingsAuthorRule = new WorkerSettingsAuthorRule();
        $auth->add($rule);
        $auth->add($postAuthorRule);
        $auth->add($profileAuthorRule);
        $auth->add($estateAuthorRule);
        $auth->add($workerSettingsAuthorRule);

        /***** Posts *****/
        // add "createPost" permission
        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create a post';
        $auth->add($createPost);

        // add "updatePost" permission
        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update post';
        $auth->add($updatePost);

        // add "updateOwnPost" permission
        $updateOwnPost = $auth->createPermission('updateOwnPost');
        $updateOwnPost->description = 'Update own post';
        $updateOwnPost->ruleName = $postAuthorRule->name;
        $auth->add($updateOwnPost);

        // add "deletePost" permission
        $deletePost = $auth->createPermission('deletePost');
        $deletePost->description = 'Delete post';
        $auth->add($deletePost);

        /***** Users (profile) *****/
        // add "createProfile" permission
        $createProfile = $auth->createPermission('createProfile');
        $createProfile->description = 'Create profile';
        $auth->add($createProfile);

        // add "updateProfile" permission
        $updateProfile = $auth->createPermission('updateProfile');
        $updateProfile->description = 'Update profile';
        $auth->add($updateProfile);

        // add "updateOwnProfile" permission
        $updateOwnProfile = $auth->createPermission('updateOwnProfile');
        $updateOwnProfile->description = 'Update own profile';
        $updateOwnProfile->ruleName = $profileAuthorRule->name;
        $auth->add($updateOwnProfile);

        // add "deleteProfile" permission
        $deleteProfile = $auth->createPermission('deleteProfile');
        $deleteProfile->description = 'Delete profile';
        $auth->add($deleteProfile);

        /***** Estates *****/
        // add "createEstate" permission
        $createEstate = $auth->createPermission('createEstate');
        $createEstate->description = 'Create an estate';
        $auth->add($createEstate);

        // add "updateEstate" permission
        $updateEstate = $auth->createPermission('updateEstate');
        $updateEstate->description = 'Update estate';
        $auth->add($updateEstate);

        // add "updateOwnEstate" permission
        $updateOwnEstate = $auth->createPermission('updateOwnEstate');
        $updateOwnEstate->description = 'Update own estate';
        $updateOwnEstate->ruleName = $estateAuthorRule->name;
        $auth->add($updateOwnEstate);

        // add "deleteEstate" permission
        $deleteEstate = $auth->createPermission('deleteEstate');
        $deleteEstate->description = 'Delete estate';
        $auth->add($deleteEstate);
		
		/***** WorkerSettings *****/
        // add "createWorkerSettings" permission
        $createWorkerSettings = $auth->createPermission('createWorkerSettings');
        $createWorkerSettings->description = 'Create Worker-settings';
        $auth->add($createWorkerSettings);

        // add "updateWorkerSettings" permission
        $updateWorkerSettings = $auth->createPermission('updateWorkerSettings');
        $updateWorkerSettings->description = 'Update Worker-settings';
        $auth->add($updateWorkerSettings);

        // add "updateOwnWorkerSettings" permission
        $updateOwnWorkerSettings = $auth->createPermission('updateOwnWorkerSettings');
        $updateOwnWorkerSettings->description = 'Update Own Worker-settings';
        $updateOwnWorkerSettings->ruleName = $workerSettingsAuthorRule->name;
        $auth->add($updateOwnWorkerSettings);

        // add "deleteWorkerSettings" permission
        $deleteWorkerSettings = $auth->createPermission('deleteWorkerSettings');
        $deleteWorkerSettings->description = 'Delete Worker-settings';
        $auth->add($deleteWorkerSettings);
        
		//Добавляем роли
        $user = $auth->createRole('user');
        $user->description = 'User';
        $user->ruleName = $rule->name;
        $auth->add($user);

        $worker = $auth->createRole('worker');
        $worker->description = 'Worker';
        $worker->ruleName = $rule->name;
        $auth->add($worker);

        $moderator = $auth->createRole('moderator');
        $moderator->description = 'Moderator';
        $moderator->ruleName = $rule->name;
        $auth->add($moderator);

        $admin = $auth->createRole('admin');
        $admin->description = 'Administrator';
        $admin->ruleName = $rule->name;
        $auth->add($admin);

		//Добавляем потомков
        $auth->addChild($worker, $user);
        $auth->addChild($moderator, $worker);
        $auth->addChild($admin, $moderator);

        /***** Posts *****/
        $auth->addChild($updateOwnPost, $updatePost);
        $auth->addChild($moderator, $createPost);
        $auth->addChild($moderator, $updateOwnPost);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $deletePost);

        /***** Users (profile) *****/
        $auth->addChild($updateOwnProfile, $updateProfile);
        $auth->addChild($user, $updateOwnProfile);
        $auth->addChild($admin, $createProfile);
        $auth->addChild($admin, $updateProfile);
        $auth->addChild($admin, $deleteProfile);

        /***** Estates *****/
        $auth->addChild($updateOwnEstate, $updateEstate);
        $auth->addChild($worker, $createEstate);
        $auth->addChild($worker, $updateOwnEstate);
        $auth->addChild($moderator, $updateEstate);
        $auth->addChild($admin, $deleteEstate);
		
        /***** WorkerSettings *****/
        $auth->addChild($updateOwnWorkerSettings, $updateWorkerSettings);
        $auth->addChild($worker, $createWorkerSettings);
        $auth->addChild($worker, $updateOwnWorkerSettings);
        $auth->addChild($moderator, $updateWorkerSettings); //todo change to admin
        $auth->addChild($admin, $deleteWorkerSettings);
    }
}