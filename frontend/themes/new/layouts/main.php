<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
$theme = $this->theme;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= Html::csrfMetaTags() ?>
    <title>Admin OLDBK v0.1</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="<?= $theme->getUrl('img/profile_small.jpg') ?>">
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs">
                                    <strong class="font-bold"><?= Yii::$app->user->identity->username; ?></strong>
                             </span> <span class="text-muted text-xs block"><?= Yii::$app->user->identity->short_description; ?> <b class="caret"></b></span> </span>
                        </a>
                        <?= \yii\widgets\Menu::widget([
                            'options' => [
                                'class' => 'dropdown-menu animated fadeInRight m-t-xs',
                            ],
                            'activateItems' => false,
                            'items' => [
                                [
                                    'label' => 'Profile',
                                    'url' => ['/site/index'],
                                ],
                                [
                                    'label' => 'Contacts',
                                    'url' => ['/site/index'],
                                ],
                                [
                                    'label' => 'Mailbox',
                                    'url' => ['/site/index'],
                                ],
                                [
                                    'options' => [
                                        'class' => 'divider'
                                    ],
                                ],
                                [
                                    'label' => 'Logout',
                                    'url' => ['/site/logout'],
                                ],
                            ],
                        ]); ?>
                    </div>
                    <div class="logo-element">
                        IN+
                    </div>
                </li>
            </ul>
            <?= \yii\widgets\Menu::widget([
                'options' => [
                    'class' => 'nav metismenu',
                    'id' => 'side-menu',
                ],
                'activateParents' => true,
                'items' => [
                    [
                        'label' => 'Дашборд',
                        'url' => ['/site/index'],
                        'template' => '<a href="{url}"><i class="fa fa-th-large"></i>  <span class="nav-label">{label}</span></a>',
                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_GAMEMASTER),
                    ],
                    [
                        'label' => 'RBAC',
                        'url' => '#',
                        'template' => '<a href="{url}"><i class="fa fa-pie-chart"></i>  <span class="nav-label">{label}</span><span class="fa arrow"></span></a>',
                        'submenuTemplate' => "\n<ul class=\"nav nav-second-level collapse\" style=\"height: 0px;\">\n{items}\n</ul>\n",
                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_SUPERADMIN),
                        'items' => [
                            [
                                'label' => 'Роуты',
                                'url' => ['/admin/route/index'],
                                'template' => '<a href="{url}">{label}</a>'
                            ],
                            [
                                'label' => 'Права',
                                'url' => ['/admin/permission/index'],
                                'template' => '<a href="{url}">{label}</a>'
                            ],
                            [
                                'label' => 'Роли',
                                'url' => ['/admin/role/index'],
                                'template' => '<a href="{url}">{label}</a>',
                            ],
                            [
                                'label' => 'Связи',
                                'url' => ['/admin/assignment/index'],
                                'template' => '<a href="{url}">{label}</a>'
                            ],
                            [
                                'label' => 'Правила',
                                'url' => ['/admin/rule/index'],
                                'template' => '<a href="{url}">{label}</a>'
                            ],
                            [
                                'label' => 'Пользователи',
                                'url' => ['/users/user/index'],
                                'template' => '<a href="{url}">{label}</a>'
                            ],
                        ]
                    ],
                    [
                        'label' => 'Новости',
                        'url' => ['/news/news/index'],
                        'template' => '<a href="{url}"><i class="fa fa-newspaper-o"></i>  <span class="nav-label">{label}</span></a>',
                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_GAMEMASTER),
                    ],
                    [
                        'label' => 'Статистика',
                        'url' => '#',
                        'template' => '<a href="{url}"><i class="fa fa-pie-chart"></i>  <span class="nav-label">{label}</span><span class="fa arrow"></span></a>',
                        'submenuTemplate' => "\n<ul class=\"nav nav-second-level collapse\" style=\"height: 0px;\">\n{items}\n</ul>\n",
                        'items' => [
                            [
                                'label' => 'Дилеры',
                                'url' => ['/stats/diler/index'],
                                'template' => '<a href="{url}">{label}</a>',
	                            'visible' => Yii::$app->user->can(\common\models\User::ROLE_DILER),
                            ],
                            [
                                'label' => 'Классы',
                                'url' => ['/stats/classes/index'],
                                'template' => '<a href="{url}">{label}</a>'
                            ],
                            [
                                'label' => 'Колесо Фортуны',
                                'url' => ['/stats/fortune/index'],
                                'template' => '<a href="{url}">{label}</a>'
                            ],
                        ],
                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_GAMEMASTER),
                    ],
					[
						'label' => 'События',
						'url' => '#',
						'template' => '<a href="{url}"><i class="fa fa fa-table"></i>  <span class="nav-label">{label}</span><span class="fa arrow"></span></a>',
						'visible' => Yii::$app->user->can(\common\models\User::ROLE_GAMEMASTER),
						'submenuTemplate' => "\n<ul class=\"nav nav-second-level collapse\" style=\"height: 0px;\">\n{items}\n</ul>\n",
						'items' => [
							[
							    'label' => 'Команды',
								'url' => ['/event/team/index'],
								'template' => '<a href="{url}">{label}</a>'
							],
							[
								'label' => 'ЧМ 2018',
								'url' => ['/event/wc18/index'],
								'template' => '<a href="{url}">{label}</a>'
							],
						],
					],
                    [
                        'label' => 'Квесты',
                        'url' => '#',
                        'template' => '<a href="{url}"><i class="fa fa-tasks"></i>  <span class="nav-label">{label}</span><span class="fa arrow"></span></a>',
                        'submenuTemplate' => "\n<ul class=\"nav nav-second-level collapse\" style=\"height: 0px;\">\n{items}\n</ul>\n",
                        'items' => [
                            [
                                'label' => 'Квесты',
                                'url' => ['/quest/quest/index'],
                                'template' => '<a href="{url}">{label}</a>'
                            ],
                            [
                                'label' => 'Категории',
                                'url' => ['/quest/category/index'],
                                'template' => '<a href="{url}">{label}</a>'
                            ],
                            [
                                'label' => 'Медали',
                                'url' => ['/quest/medal/index'],
                                'template' => '<a href="{url}">{label}</a>'
                            ],
                            [
                                'label' => 'События',
                                'url' => ['/quest/event/index'],
                                'template' => '<a href="{url}">{label}</a>'
                            ],
                        ],
                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_GAMEMASTER),
                    ],
                    [
                        'label' => 'Лотерея',
                        'url' => '#',
                        'template' => '<a href="{url}"><i class="fa fa-gift"></i>  <span class="nav-label">{label}</span><span class="fa arrow"></span></a>',
                        'submenuTemplate' => "\n<ul class=\"nav nav-second-level collapse\" style=\"height: 0px;\">\n{items}\n</ul>\n",
                        'items' => [
                            [
                                'label' => 'Списки призов',
                                'url' => ['/loto/pocket/index'],
                                'template' => '<a href="{url}">{label}</a>',
                            ],
                            [
                                'label' => 'Статистика',
                                'url' => ['/loto/stat/index'],
                                'template' => '<a href="{url}">{label}</a>'
                            ],
                        ],
                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_GAMEMASTER),
                    ],
                    [
                        'label' => 'Предметы',
                        'url' => '#',
                        'template' => '<a href="{url}"><i class="fa fa-pie-chart"></i>  <span class="nav-label">{label}</span><span class="fa arrow"></span></a>',
                        'submenuTemplate' => "\n<ul class=\"nav nav-second-level collapse\" style=\"height: 0px;\">\n{items}\n</ul>\n",
                        'items' => [
							[
								'label' => 'Пулы',
								'url' => ['/pool/manager/index'],
								'template' => '<a href="{url}"><i class="fa fa-pie-chart"></i>  <span class="nav-label">{label}</span></a>',
								'visible' => Yii::$app->user->can(\common\models\User::ROLE_GAMEMASTER),
							],
                            [
                                'label' => "------------------------",
								'template' => '<a href="javascript::void(0)">{label}</a>',
                            ],
                            [
                                'label' => 'Личные реликты',
                                'url' => ['/item/ability/index'],
                                'template' => '<a href="{url}">{label}</a>'
                            ],
							[
								'label' => 'Гос. магазин',
								'url' => ['/item/shop/index'],
								'template' => '<a href="{url}">{label}</a>'
							],
							[
								'label' => 'Березка',
								'url' => ['/item/eshop/index'],
								'template' => '<a href="{url}">{label}</a>'
							],
							[
								'label' => 'Храм',
								'url' => ['/item/cshop/index'],
								'template' => '<a href="{url}">{label}</a>'
							],
							[
								'label' => 'Ярмарка',
								'url' => ['/item/fairshop/index'],
								'template' => '<a href="{url}">{label}</a>'
							],
                        ],
                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_DRESSROOM),
                    ],
                    [
                        'label' => 'Производство',
                        'url' => '#',
                        'template' => '<a href="{url}"><i class="fa fa-pie-chart"></i>  <span class="nav-label">{label}</span><span class="fa arrow"></span></a>',
                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_GAMEMASTER),
                        'submenuTemplate' => "\n<ul class=\"nav nav-second-level collapse\" style=\"height: 0px;\">\n{items}\n</ul>\n",
                        'items' => [
                            [
                                'label' => 'Рецепты',
                                'url' => ['/recipe/recipe/index'],
                                'template' => '<a href="{url}">{label}</a>'
                            ],
                            [
                                'label' => 'Статистика',
                                'url' => ['/recipe/stats/index'],
                                'template' => '<a href="{url}">{label}</a>'
                            ],
                        ],
                    ],
                    [
                        'label' => 'Сообщения',
                        'url' => ['/message/index'],
                        'template' => '<a href="{url}"><i class="fa fa-pie-chart"></i>  <span class="nav-label">{label}</span></a>',
                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_GAMEMASTER),
                    ],
                    [
                        'label' => 'Рейтинг',
                        'url' => '#',
                        'template' => '<a href="{url}"><i class="fa fa-pie-chart"></i>  <span class="nav-label">{label}</span><span class="fa arrow"></span></a>',
                        'submenuTemplate' => "\n<ul class=\"nav nav-second-level collapse\" style=\"height: 0px;\">\n{items}\n</ul>\n",
                        'items' => [
                            [
                                'label' => 'Описание',
                                'url' => ['/rate/item/index'],
                                'template' => '<a href="{url}">{label}</a>'
                            ],
							[
								'label' => 'Менеджер',
								'url' => ['/rate/manager/index'],
								'template' => '<a href="{url}">{label}</a>'
							],
                        ],
                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_GAMEMASTER),
                    ],
                    [
                        'label' => 'Настройки',
                        'url' => ['/settings/default/index'],
                        'template' => '<a href="{url}"><i class="fa fa-pie-chart"></i>  <span class="nav-label">{label}</span></a>',
                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_GAMEMASTER),
                    ],
                    [
                        'label' => 'Плагин',
                        'url' => '#',
                        'template' => '<a href="{url}"><i class="fa fa-pie-chart"></i>  <span class="nav-label">{label}</span><span class="fa arrow"></span></a>',
                        'submenuTemplate' => "\n<ul class=\"nav nav-second-level collapse\" style=\"height: 0px;\">\n{items}\n</ul>\n",
                        'items' => [
                            [
                                'label' => 'Левые пользователи',
                                'url' => ['/plugin/other'],
                                'template' => '<a href="{url}">{label}</a>'
                            ],
                            [
                                'label' => 'Левые ссылки',
                                'url' => ['/plugin/link'],
                                'template' => '<a href="{url}">{label}</a>'
                            ],
                        ],
                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_GAMEMASTER),
                    ],
                    [
                        'label' => 'Библиотека',
                        'url' => '#',
                        'template' => '<a href="{url}"><i class="fa fa-pie-chart"></i>  <span class="nav-label">{label}</span><span class="fa arrow"></span></a>',
                        'submenuTemplate' => "\n<ul class=\"nav nav-second-level collapse\" style=\"height: 0px;\">\n{items}\n</ul>\n",
                        'items' => [
                            [
                                'label' => 'Категории',
                                'url' => ['/library/category/index'],
                                'template' => '<a href="{url}">{label}</a>'
                            ],
                            [
                                'label' => 'Страницы',
                                'url' => ['/library/page/index'],
                                'template' => '<a href="{url}">{label}</a>'
                            ],
                            [
                                'label' => 'Списки вещей',
                                'url' => ['/library/pocket/index'],
                                'template' => '<a href="{url}">{label}</a>'
                            ],
                        ],
                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_LIBRARY),
                    ],
                    [
                        'label' => 'Фильтр матов',
                        'url' => '#',
                        'template' => '<a href="{url}"><i class="fa fa-pie-chart"></i>  <span class="nav-label">{label}</span><span class="fa arrow"></span></a>',
                        'submenuTemplate' => "\n<ul class=\"nav nav-second-level collapse\" style=\"height: 0px;\">\n{items}\n</ul>\n",
                        'items' => [
                            [
                                'label' => 'Фильтр слов',
                                'url' => ['/wordfilter/wordfilter/index'],
                                'template' => '<a href="{url}">{label}</a>'
                            ],
                            [
                                'label' => 'Слова-исключения',
                                'url' => ['/wordfilter/wordfilterexception/index'],
                                'template' => '<a href="{url}">{label}</a>'
                            ],
                            [
                                'label' => 'Проверка',
                                'url' => ['/wordfilter/wordfiltertest/index'],
                                'template' => '<a href="{url}">{label}</a>'
                            ],
                            [
                                'label' => 'Чистка форума',
                                'url' => ['/wordfilter/forumcleaner/index'],
                                'template' => '<a href="{url}">{label}</a>'
                            ],
                        ],
                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_WORDFILTER),
                    ],
                    [
                        'label' => 'Подсказки в игре',
                        'url' => ['/gamehelp/default/index'],
                        'template' => '<a href="{url}"><i class="fa fa-pie-chart"></i>  <span class="nav-label">{label}</span></a>',
                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_LIBRARY),
                    ],
                    [
                        'label' => 'Редактирование ботов',
                        'url' => ['/usersedit/botedit/index'],
                        'template' => '<a href="{url}"><i class="fa fa-pie-chart"></i>  <span class="nav-label">{label}</span></a>',
                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_GAMEMASTER),
                    ],
                    [
                        'label' => 'Картинки',
                        'url' => '#',
                        'template' => '<a href="{url}"><i class="fa fa-pie-chart"></i>  <span class="nav-label">{label}</span><span class="fa arrow"></span></a>',
                        'submenuTemplate' => "\n<ul class=\"nav nav-second-level collapse\" style=\"height: 0px;\">\n{items}\n</ul>\n",
                        'items' => [
                            [
                                'label' => 'Личные картинки',
                                'url' => ['/images/personal/index'],
                                'template' => '<a href="{url}">{label}</a>'
                            ],
                        ],
                        'visible' => Yii::$app->user->can(\common\models\User::ROLE_GAMEMASTER),
                    ],

					[
						'label' => 'Экспорт',
						'url' => '#',
						'template' => '<a href="{url}"><i class="fa fa-pie-chart"></i>  <span class="nav-label">{label}</span><span class="fa arrow"></span></a>',
						'submenuTemplate' => "\n<ul class=\"nav nav-second-level collapse\" style=\"height: 0px;\">\n{items}\n</ul>\n",
						'items' => [
							[
								'label' => 'Email',
								'url' => ['/export/email/index'],
								'template' => '<a href="{url}">{label}</a>'
							],
						],
						'visible' => Yii::$app->user->can(\common\models\User::ROLE_SUPERADMIN),
					],
                ],
            ]); ?>
        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    <form role="search" class="navbar-form-custom" method="post" action="#">
                        <div class="form-group">
                            <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                        </div>
                    </form>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <?= (new DateTime())->format('d.m.Y H:i') ?>
                    </li>
                    <li><?= Html::a('<i class="fa fa-sign-out"></i> Log out', ['/site/logout']) ?></li>
                </ul>

            </nav>
        </div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
                <h2><?= $this->title ?></h2>
                <?= Breadcrumbs::widget([
                    'homeLink' => [
                        'label' => 'Дашборд',
                        'url'   => Yii::$app->homeUrl
                    ],
                    'tag' => 'ol',
                    'itemTemplate' => "<li>{link}</li>\n", // template for all links
                    'activeItemTemplate' => "<li class=\"active\"><strong>{link}</strong></li>\n",
                    'links' => Yii::$app->breadcrumbs->get(),
                ]); ?>
            </div>
            <div class="col-lg-2">

            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
        <div class="footer">
            <div class="pull-right">
                10GB of <strong>250GB</strong> Free.
            </div>
            <div>
                <strong>Copyright</strong> <?= Yii::powered() ?>
            </div>
        </div>

    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
