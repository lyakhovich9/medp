<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
//СОЗДАНИЕ ЛОГО
$logo = Html::img('@web/images/logo.svg', ['alt' => 'Логотип', 'class' => 'navbar-brand logo']);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => 'Мед Плюс',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
    ]);

    $items = [
        ['label' => $logo, 'url' => ['site/index'], 'encode' => false],
        ['label' => 'Главная', 'url' => ['site/index']],
    ];
        if (Yii::$app->user->isGuest) {
            $items[] = ['label' => 'Вход', 'url' => ['/site/login']];
            $items[] = ['label' => 'Регистрация', 'url' => ['/site/register']];
        } else {
            $items[] = ['label' => 'Мои записи', 'url' => ['reception/index']];
            $items[] = ['label' => 'Запись на прием', 'url' => ['/reception/create']];
            $items[] = '<li class="nav-item">'
                . Html::beginForm(['/site/logout'])
                . Html::submitButton(
                    
                    'Logout (' . Yii::$app->user->identity->fio . ')',
                    ['class' => 'nav-link btn btn-link logout']
                )
                . Html::endForm()
            . '</li>';
        }
    
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav align-items-center'],
        'items' => $items
    ]);
    NavBar::end();
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">
                <?php if (Yii::$app->user->isGuest): ?>
                    <ul class="nav ">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Yii::$app->urlManager->createUrl(['/site/index']) ?>">Главная</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Yii::$app->urlManager->createUrl(['/site/login']) ?>">Авторизация</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Yii::$app->urlManager->createUrl(['/site/register']) ?>">Регистрация</a>
                        </li>
                    </ul>
                    <?php else:?>
                        <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Yii::$app->urlManager->createUrl(['/reception/index']) ?>">Мои записи</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Yii::$app->urlManager->createUrl(['/reception/create']) ?>">Запись на прием</a>
                        </li>
                    </ul>
                    <?php endif; ?>
            </div>

            <div class="col-md-6 text-center text-md-end">
                <h4>Контактная информация</h4>
                <p>Телефон: +7 (999) 888 33-22</p>
                <p>Email: med-plus@mail.ru</p>
            </div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>