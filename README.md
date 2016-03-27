
## Features ##
- WEB UI Manager
- Route Access Filter

## Todo ##
- I18n

## Install ##
via Composer

    composer require wsdslm/yii2-rbac

## Config ##

    # config/web.php
    'components' => [
        'authManager' => [
            'class' => yii\rbac\DbManager::className(),
        ]
    ],
    'modules' => [
        'rbac' => [
            'class' => ws\rbac\Module::className(),
        ]
    ],

database migration

    yii migrate --migrationPath=@yii/rbac/migrations

## Usage ##

### use Route Access Filter ###
1. add `ws\rbac\components\RouteAccessFilter` for `app\controllers\SiteController`

        use ws\rbac\components\RouteAccessFilter;

        public function behaviors()
        {
            return [
                'rbac' => [
                    'class' => RouteAccessFilter::className(),
                    'only' => ['t'],
                ],
            ];
        }

        public function actionT()
        {
            return __METHOD__;
        }

2. Create Route access Permission at `http://localhost:8080/rbac/permission/create`
    1. Permission Name `basic.site.t` (`module_id.controller_id.action_id`)
3. Create Role at `http://localhost:8080/rbac/role/create`
    1. Role Name `admin`
4. Manager Role at `http://localhost:8080/rbac/role/index`
    1. Click icon cog
    2. Add Child `basic.site.t`
5. Assign Role for User at `http://localhost:8080/rbac/assign`
