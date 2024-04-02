<?php
global $config, $tmpl, $module, $user;
$Itemid = FSInput::get('Itemid', 1, 'int');
$totalCart = 0;
if (!empty($_SESSION['cart'])) {
    $totalCart = count($_SESSION['cart']);
}
if (!$user->userID) {
    $tmpl->addScript('no-user');
}

$userImage = 'images/user-icon.svg';

if ($user->userID) {
    $userImage = $user->userInfo->image ?: 'images/user-customer-icon.svg';
}
$total_money_cart = 0;
$cart = new FSControllers();
$cartList = $cart->calculateCartPrice();
$alert = array(
    0 => FSText::_('Bạn chưa nhập họ và tên'),
    1 => FSText::_('Bạn chưa nhập mật khẩu'),
    2 => FSText::_('Bạn chưa nhập email'),
    3 => FSText::_('Email không đúng định dạng'),
    4 => FSText::_('Nhập mật khẩu của bạn'),
    5 => FSText::_('Nhập lại mật khẩu của bạn'),
    6 => FSText::_('Mật khẩu chưa đúng, vui lòng nhập lại'),
    8 => FSText::_('Mật khẩu có ít nhất 8 ký tự'),
);


?>

<?php if ($Itemid == 50) { ?>
    <?php include_once './indexAmp.php'; ?>
<?php } else { ?>
    <div id="app">
        <input type="hidden" id="alert_member" value='<?php echo json_encode($alert) ?>' />
        <header class="bg-white">
            <div class="container header-container d-flex align-items-center gap-5">
                <a href="<?php echo URL_ROOT ?>" title="<?php echo $config['site_name'] ?>">
                    <img src="<?php echo URL_ROOT . $config['logo'] ?>" width="100" height="48.5" alt="<?php echo $config['site_name'] ?>" class="img-fluid img-logo">
                </a>
                <div class="header-top bg-white">
                    <?= $tmpl->load_direct_blocks('mainmenu', ['style' => 'megamenu', 'group' => '1']) ?>
                </div>
            </div>
            <div class="container header-container d-flex justify-content-between  flex-row flex-nowrap  align-items-center">
                <div class="img-thongbao">
                    <img src="/images/thongbao.svg" alt="thognbao.svg">
                </div>
                <div class="heder-center">
                    <?php echo $tmpl->load_direct_blocks('search', ['style' => 'default']); ?>
                </div>

                <div class="header-right d-flex align-items-center justify-content-end">
                    <a href="<?php echo FSRoute::_('index.php?module=products&view=cart') ?>" title="<?php echo FSText::_('Giỏ hàng') ?>" class="header-cart position-relative">
                        <div class="cart-session d-grid">
                            <div class="cart-session-left">
                                <img src="./images/image-cart.svg" alt="gio-hang">
                            </div>
                            <div class="cart-session-right">
                                <div class="cart-quantity cart-text-quantity  d-flex align-items-center justify-content-center fw-bold"><?php echo $totalCart ?></div>
                                <span></span>
                                <p class="mb-0">Cart</p>
                            </div>
                        </div>
                    </a>
                    <div class="cart-hover">
                        <div class="cart-hover-header d-flex flex-wrap align-items-center justify-content-between">
                            <h3 class="title_cart ">
                                <?php echo FSText::_('Giỏ hàng') ?>
                            </h3>
                            <p class="quantity_cart">
                                <?php if (!empty($cartList)) { ?>
                                    <span><?= count($cartList) . ' ' ?></span> <?= FSText::_('sản phẩm') ?>
                                <?php } ?>
                            </p>
                        </div>

                        <div class="cart-hover-body">
                            <?php if (!empty($cartList)) { ?>
                                <?php foreach ($cartList as $item) {
                                    $total_money_cart +=  $total_money_cart + ($item['price'] * $item['quantity']);
                                ?>
                                    <div class="cart-hover-item position-relative">
                                        <a href="<?php echo $item['url'] ?>" class=""><img src="<?php echo $item['image'] ?>" alt="<?php echo $item['product_name'] ?>" class="img-fluid"></a>
                                        <div>
                                            <a href="<?php echo $item['url'] ?>">
                                                <div class="mb-1"><?php echo $item['product_name'] ?></div>
                                                <div class="sub-name"><?php echo @$item['sub_name'] ?></div>
                                                <div class="item-price d-flex flex-wrap align-items-center justify-content-between">
                                                    <p><?php echo format_money($item['price']) ?>
                                                        <span class="span-price-origin"><?php echo format_money($item['price_old']) ?></span>
                                                    </p>
                                                    <p><?php echo 'x ' . ($item['quantity']) ?></p>
                                                </div>
                                            </a>
                                        </div>
                                        <a href="" class="delete-cart position-absolute top-0 end-0" data-id="<?php echo $item['product_id'] ?>">
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11.6201 2.38L2.38013 11.62M2.38013 2.38L11.6201 11.62" stroke="#757575" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </a>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                        <div class=" cart-hover-footer">
                            <div class="text-tamtinh text-center"><span>Tạm tính</span><b class="cart-text-quantity"><?= format_money($total_money_cart) ?></b></div>
                            <p class="mt-3 mb-3 text-center">Mã vận chuyển, thuế và giảm giá được tính khi thanh toán.</p>
                            <a class="text-center" href="<?php echo FSRoute::_('index.php?module=products&view=cart') ?>"><?php echo FSText::_('Thanh toán') ?></a>
                        </div>
                    </div>
                </div>
            </div>


        </header>

        <div class="app-main-content pt-3 pb-3"><?php echo $main_content; ?></div>
        <div id="menu_mobile">
            <?php echo $tmpl->load_direct_blocks('botmenumobile', ['style' => 'default']); ?>
        </div>
        <footer>
            <div class="container bg-white">
                <div class="footer-top">
                    <div class="item">
                        <p class="fw-semibold fs-6 mb-2 title"><?php echo FSText::_('Hỗ trợ khách hàng') ?></p>
                        <?php echo $tmpl->load_direct_blocks('mainmenu', ['style' => 'footer', 'group' => '2']); ?>
                    </div>
                    <div class="item">
                        <p class="fw-semibold fs-6 mb-2 title"><?php echo FSText::_('Về chúng tôi') ?></p>
                        <?php echo $tmpl->load_direct_blocks('mainmenu', ['style' => 'footer', 'group' => '3']); ?>
                        <p class="fw-semibold fs-6 mb-2 mt-4 title"><?php echo FSText::_('Tổng đài hỗ trợ') ?></p>
                        <div>Hotline: <a href="tel:<?php echo $config['hotline'] ?>"><b><?php echo $config['hotline'] ?></b></a> <br> (1000đ/phút, 8-21h kể cả T7, CN)</div>
                    </div>
                    <div class="item">
                        <p class="fw-semibold fs-6 mb-2 title"><?php echo FSText::_('Phương thức thanh toán') ?></p>
                        <img src="<?php echo URL_ROOT ?>images/phuong-thuc-thanh-toan.svg" alt="<?php echo FSText::_('Phương thức thanh toán') ?>" class="img-responsive">
                    </div>
                    <div class="item">
                        <p class="fw-semibold fs-6 mb-2 title"><?php echo FSText::_('Chứng nhận') ?></p>
                        <img src="<?php echo URL_ROOT ?>images/chung-nhan.jpg" alt="Chứng nhận" class="img-fluid">
                    </div>
                    <div class="item">
                        <p class="fw-semibold fs-6 mb-2 title"><?php echo FSText::_('Kết nối với chúng tôi') ?></p>
                        <div class="mb-2">
                            <a href="<?php echo $config['facebook'] ?>" title="Facebook" class="d-inline-flex align-items-center gap-2">
                                <img src="<?php echo URL_ROOT ?>images/facebook-circle-icon.svg" alt="Facebook" class="img-fluid">
                                Fanpage
                            </a>
                        </div>
                        <div class="mb-2">
                            <a href="<?php echo $config['shopee'] ?>" title="Shopee" class="d-inline-flex align-items-center gap-2">
                                <img src="<?php echo URL_ROOT ?>images/shopee-circle-icon.svg" alt="Shopee" class="img-fluid">
                                Shopee
                            </a>
                        </div>
                        <div class="mb-2">
                            <a href="<?php echo $config['tiktok'] ?>" title="Tiktok" class="d-inline-flex align-items-center gap-2">
                                <img src="<?php echo URL_ROOT ?>images/tiktok-circle-icon.svg" alt="Tiktok" class="img-fluid">
                                Tiktok
                            </a>
                        </div>
                        <div class="mb-2">
                            <a href="<?php echo $config['youtube'] ?>" title="Youtube" class="d-inline-flex align-items-center gap-2">
                                <img src="<?php echo URL_ROOT ?>images/youtube-circle-icon.svg" alt="Youtube" class="img-fluid">
                                Youtube
                            </a>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom text-center">
                    <p class="mb-1"><?php echo $config['company'] ?></p>
                    <p class="mb-1"><?php echo $config['address'] ?></p>
                    <p class="mb-0"><?php echo $config['copyright'] ?></p>
                </div>
            </div>
        </footer>
    </div>
    <input type="hidden" value="<?php echo URL_ROOT ?>" id="root" />
    <input type="hidden" value="<?php echo $_SESSION['token'] ?>" id="csrf-token">
<?php } ?>

<div id="flash-message-container" class="w-100 h-100 position-fixed left-0 top-0 flash-message-container">
    <div class="d-flex align-items-center justify-content-center w-100 h-100 ">
        <div id="flash-message" class="p-4 text-center flash-message">
            <svg width="52" height="52" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg" class="svg-success">
                <rect width="52" height="52" rx="26" fill="#3BA500" fill-opacity="0.08" />
                <rect x="6" y="6" width="40" height="40" rx="20" fill="#3BA500" fill-opacity="0.08" />
                <path d="M21.75 26L24.58 28.83L30.25 23.17M26 36C31.5 36 36 31.5 36 26C36 20.5 31.5 16 26 16C20.5 16 16 20.5 16 26C16 31.5 20.5 36 26 36Z" stroke="#3BA500" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <svg width="52" height="52" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg" class="svg-error">
                <rect width="52" height="52" rx="26" fill="#E81B2B" fill-opacity="0.08" />
                <rect x="6" y="6" width="40" height="40" rx="20" fill="#E81B2B" fill-opacity="0.08" />
                <path d="M23.17 28.83L28.83 23.17M28.83 28.83L23.17 23.17M26 36C31.5 36 36 31.5 36 26C36 20.5 31.5 16 26 16C20.5 16 16 20.5 16 26C16 31.5 20.5 36 26 36Z" stroke="#E81B2B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <div class="message mt-3"></div>
        </div>
    </div>
</div>