<?php
// Yii::setAlias('@uploads', '../web/uploads/');
Yii::setAlias('@imageBaseUrl', 'http://onefic.test/uploads');
return [
    //'bsDependencyEnabled' => false,
    'bsVersion' => '4.x',

    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',

    'defaultPageSize' => 10,

    'appUrl' => 'https://onefic.test/',
    'base_upload_folder' => 'uploads',
    'equipment_folder' => 'equipments',
    'part_folder' => 'parts',
    'supplier_folder' => 'suppliers',
    'equipment_issue_folder' => 'equipment-issues',
    'product_image_folder' => 'products',

    'user.passwordResetTokenExpire' => 3600,
];
