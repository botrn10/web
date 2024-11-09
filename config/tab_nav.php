<?php
/**
 * Created by PhpStorm .
 * User: trungphuna .
 * Date: 5/6/23 .
 * Time: 9:36 AM .
 */


return [
    'backend' => [
        'profile' => [
            'tab_nav' => [
                [
                    'name' => 'Thông tin cá nhân',
                    'route' => 'get_admin.profile.index'
                ],
                [
                    'name' => 'Đổi mật khẩu',
                    'route' => 'get_admin.profile.update_password'
                ],
              
            ]
        ]
    ]
];
