<div class="footer mui-bar mui-bar-tab my-bar">
    <a class="mui-tab-item <?php if($active == 1){echo 'active';} ?>" href="<?= \yii\helpers\Url::to(['home/index']) ?>">
        <span class="mui-icon jishi"></span>
        <span class="mui-tab-label">机市</span>
    </a>
    <a class="mui-tab-item <?php if($active == 2){echo 'active';} ?>" href="<?= \yii\helpers\Url::to(['home/my-product']) ?>">
        <span class="mui-icon kuangji"></span>
        <span class="mui-tab-label">矿机</span> </a>
    <a class="mui-tab-item <?php if($active == 3){echo 'active';} ?>" href="<?= \yii\helpers\Url::to(['home/team']) ?>">
        <span class="mui-icon kuangchi"></span>
        <span class="mui-tab-label">矿池</span>
    </a>
    <a class="mui-tab-item <?php if($active == 4){echo 'active';} ?>" href="<?= \yii\helpers\Url::to(['shopping/index']) ?>">
        <span class="mui-icon kuangshi"></span>
        <span class="mui-tab-label">矿市</span>
    </a>
    <a class="mui-tab-item  <?php if($active == 5){echo 'active';} ?>" href="<?= \yii\helpers\Url::to(['member/index']) ?>">
        <span class="mui-icon wode"></span>
        <span class="mui-tab-label">我的</span>
    </a>
</div>