<?php
return [
    'createPost' => [
        'type' => 2,
        'description' => 'Create a post',
    ],
    'updatePost' => [
        'type' => 2,
        'description' => 'Update post',
    ],
    'updateOwnPost' => [
        'type' => 2,
        'description' => 'Update own post',
        'ruleName' => 'postAuthor',
        'children' => [
            'updatePost',
        ],
    ],
    'deletePost' => [
        'type' => 2,
        'description' => 'Delete post',
    ],
    'createProfile' => [
        'type' => 2,
        'description' => 'Create profile',
    ],
    'updateProfile' => [
        'type' => 2,
        'description' => 'Update profile',
    ],
    'updateOwnProfile' => [
        'type' => 2,
        'description' => 'Update own profile',
        'ruleName' => 'profileAuthor',
        'children' => [
            'updateProfile',
        ],
    ],
    'deleteProfile' => [
        'type' => 2,
        'description' => 'Delete profile',
    ],
    'createEstate' => [
        'type' => 2,
        'description' => 'Create an estate',
    ],
    'updateEstate' => [
        'type' => 2,
        'description' => 'Update estate',
    ],
    'updateOwnEstate' => [
        'type' => 2,
        'description' => 'Update own estate',
        'ruleName' => 'estateAuthor',
        'children' => [
            'updateEstate',
        ],
    ],
    'deleteEstate' => [
        'type' => 2,
        'description' => 'Delete estate',
    ],
    'createWorkerSettings' => [
        'type' => 2,
        'description' => 'Create Worker-settings',
    ],
    'updateWorkerSettings' => [
        'type' => 2,
        'description' => 'Update Worker-settings',
    ],
    'updateOwnWorkerSettings' => [
        'type' => 2,
        'description' => 'Update Own Worker-settings',
        'ruleName' => 'workerSettingsAuthor',
        'children' => [
            'updateWorkerSettings',
        ],
    ],
    'deleteWorkerSettings' => [
        'type' => 2,
        'description' => 'Delete Worker-settings',
    ],
    'user' => [
        'type' => 1,
        'description' => 'User',
        'ruleName' => 'userRole',
        'children' => [
            'updateOwnProfile',
        ],
    ],
    'worker' => [
        'type' => 1,
        'description' => 'Worker',
        'ruleName' => 'userRole',
        'children' => [
            'user',
            'createEstate',
            'updateOwnEstate',
            'createWorkerSettings',
            'updateOwnWorkerSettings',
        ],
    ],
    'moderator' => [
        'type' => 1,
        'description' => 'Moderator',
        'ruleName' => 'userRole',
        'children' => [
            'worker',
            'createPost',
            'updateOwnPost',
            'updateEstate',
            'updateWorkerSettings',
        ],
    ],
    'admin' => [
        'type' => 1,
        'description' => 'Administrator',
        'ruleName' => 'userRole',
        'children' => [
            'moderator',
            'updatePost',
            'deletePost',
            'createProfile',
            'updateProfile',
            'deleteProfile',
            'deleteEstate',
            'deleteWorkerSettings',
        ],
    ],
];
