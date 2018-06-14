<div class="breadcrumbs" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="icon-home home-icon"></i>
            <a href="#">首页</a>
        </li>
        <li class="active">控制台</li>
    </ul>
</div>
<style>
    .class1 {
        padding: 10px;
    }
</style>
<div class="page-content">
    <div class="row">
        <div class="col-md-4 class1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">会员总人数</h3>
                </div>
                <div class="panel-body">
                    <?php echo $member_all; ?>
                </div>
            </div>


        </div>

        <div class="col-md-4 class1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">矿机总台数（运行中）</h3>
                </div>
                <div class="panel-body">
                    <?php echo $product_count; ?>
                </div>
            </div>
        </div>

        <div class="col-md-4 class1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">矿机总算力（运行中）</h3>
                </div>
                <div class="panel-body">
                    <?php echo $product_num; ?>
                </div>
            </div>
        </div>

        <div class="col-md-4 class1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">虚拟币总量</h3>
                </div>
                <div class="panel-body">
                    <?php echo $money; ?>
                </div>
            </div>
        </div>

    </div>

    <!--制度说明开始-->
    <h3>制度说明</h3>
    <p>虚拟币矿机</p>
    <p>
        10币购进迷你矿机：0.18币/天，180天 <br>
        50币购进小型矿机：1.03币/天，170天 <br>
        250币购进中型：5.47币/天，160天 <br>
        1250币购进大型：33.34币/天，150天 <br>
        6250币购进巨型矿机：180.58币/天，140天
    </p>
    <br>
    <p>认证只需填写正确的证件号码和银行卡号（同一人）即可，无需上传任何照片。系统会自动比对真假，一分钟内即可完成，无需人工审核。</p>
    <p>直推十人，建微信群300人以上奖励10个币。总计1000个名额，奖完即止！</p>
    <br>
    <p>
        虚拟币兑换现实币 <br>
        虚拟币兑换现实币需要收取卖家20%手续费 <br>
        交易方式：全网指定交易人 <br>
    </p>
    <br>
    <p>
        算力 <br>
        伞下每投资一个矿机为领导人提供算力。必须是运行中的矿机 <br>
        微型：1算力 <br>
        小型：5算力 <br>
        中型：25算力 <br>
        大型：125算力 <br>
        巨型：625算力 <br>
    </p>
    <br>
    <p>
        动态奖 <br>
        1：1烧伤：如果自己当天产出3个币，伞下单个某会员产出5个币，那么按照3个币的产出拿此会员领导奖 <br>
        <br>
        普通矿工：需有一台正常运转的矿机 <br>
        享受一代当天产出5% <br>
        一级矿工：矿池算力达到100，直推三名普通矿工 <br>
        赠送小型矿机一台。<br>
        开启二代当天产出2% <br>
        <br>
        二级矿工：矿池算力达到500，直推三个一级矿工 <br>
        赠送中型矿机一台 <br>
        开启三代会员的3% <br>
        <br>
        三级矿工：矿池算力达到2500，直推三个二级矿工 <br>
        赠送大型矿机一台 <br>
        开启四代会员的4% <br>
        <br>
        四级矿工：矿池算力达到12500，直推三个三级矿工 <br>
        赠送巨型矿机一台 <br>
        开启五代会员的5% <br>
    </p>
    <br>
    <p>
        币是0.1元发行价 <br>
        可挖掘总币量为1000万枚 <br>
        在总挖掘量达到500万枚后上交易所。
    </p>
    <!--制度说明结束-->
    <br>
    <p>添加制度：用户每日签到送虚拟币</p>
    <p>锁仓制度：矿机每日收益的10%（后台配置参数）锁仓，锁仓币可用于购买消耗，后台可释放锁仓币进入可用币钱包</p>
</div>