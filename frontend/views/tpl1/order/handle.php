<?php if ($message): ?>
    <?php foreach ($message as $order): ?>
        <li>
            <div class="code">
                <div class="codeleft">
                    <div class="circle"></div>
                    <p>单号：<?= $order->order_number ?></p></div>
                <div class="time"><?= date('m月d月 H时i分', $order->create_time) ?></div>
            </div>
            <!--买入交易-->
            <?php if ($order->buy_member_id == $ownId): ?>
                <div class="info">收到<?= $order->getSaleMemberName() ?>
                    （ID：<?= $order->sale_member_id ?>
                    ）转入<?= $order->number ?><?= $money_name ?>，单价：<?= $order->price ?>元。
                </div>
            <?php endif; ?>
            <!--卖出交易-->
            <?php if ($order->sale_member_id == $ownId): ?>
                <div class="info">卖给<?= $order->getBuyMemberName() ?>
                    （ID：<?= $order->buy_member_id ?>）<?= $order->number ?><?= $money_name ?>
                    ，单价：<?= $order->price ?>元。
                </div>
            <?php endif; ?>
            <?php if ($order->buy_member_id == $ownId): ?>
                <div class="btnbox">
                    <button class="look" type="button" data-type="1"
                            onclick="showUserInfo(this)"
                            data-url="<?= \yii\helpers\Url::to(['shopping/show-info', 'memberId' => $order->sale_member_id]) ?>">
                        交易账号
                    </button>
                    <?php if ($order->status == 2): ?>
                        <button class="succ" id="select_file" onclick="selectFile()"
                                type="button">
                            <?php if (!empty(trim($order->image))): ?>
                                重新上传
                            <?php endif; ?>
                            <?php if (empty(trim($order->image))): ?>
                                上传凭据
                            <?php endif; ?>
                        </button>
                        <input type="file" data-id="<?= $order->id ?>" id="image_file"
                               data-url="<?= \yii\helpers\Url::to('upload/upload') ?>"
                               onchange="uploadImage(this)" style="display: none">
                    <?php endif; ?>
                    <button class="succ" id="show_image" onclick="showImage(this)"
                            data-image="<?= $order->image ?>"
                            <?php if (empty(trim($order->image))): ?>style="display: none" <?php endif; ?>
                            type="button">查看凭据
                    </button>
                    <?php if ($order->status == 2): ?>
                        <button class="succ" type="button" data-id="<?= $order->id ?>"
                                onclick="confirmOrder(this)">确认已打款
                        </button>
                    <?php endif; ?>
                    <?php if ($order->status == 1): ?>
                        <button class="esc" data-id="<?= $order->id ?>" onclick="cancelOrder(this)" type="button">取消交易</button>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if ($order->sale_member_id == $ownId): ?>
                <div class="btnbox">
                    <button class="look" type="button" data-type="2"
                            onclick="showUserInfo(this)"
                            data-url="<?= \yii\helpers\Url::to(['shopping/show-info', 'memberId' => $order->buy_member_id]) ?>">
                        交易账号
                    </button>
                    <?php if ($order->status == 3): ?>
                        <button class="succ" onclick="showImage(this)"
                                data-image="<?= $order->image ?>" type="button">查看凭据
                        </button>
                        <button class="succ" onclick="saleOrder(this)"
                                data-id="<?= $order->id ?>" type="button">确认收款
                        </button>
                    <?php endif; ?>
                    <?php if ($order->status == 2): ?>
                        <button class="esc" data-id="<?= $order->id ?>" onclick="cancelOrder(this)" type="button">取消交易</button>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
<?php endif; ?>

