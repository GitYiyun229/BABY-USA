<?php
$this->dt_form_begin(1, 2, FSText::_('Chọn sản phẩm'), 'fa-gift', 1, 'col-md-12 fl-left');
//TemplateHelper::dt_edit_selectbox(FSText::_('Đơn vị tính'), 'discount_unit', (int)@$flash_sale->discount_unit, 0, $arr_unitDiscount, $field_value = 'id', $field_label = 'name', $size = 1, 0, '', '', '', '', 'col-md-2', 'col-md-10');
//TemplateHelper::dt_checkbox(FSText::_('Loại quà tặng'), 'is_shared', @$flash_sale->is_shared, 0, '', '', 'Áp dụng giá trị giảm cho tất cả các sản phẩm được chọn bên dưới', 'col-md-2', 'col-md-10');
?>
<div class="products_related">
    <div class="row">
        <div class="col-xs-12">
            <div class='products_related_search row'>
                <div class="row-item col-xs-6" style="margin-bottom: 20px;">
                    <select class="form-control chosen-select" name="products_related_category_id"
                            id="products_related_category_id">
                        <option value="">Danh mục</option>
                        <?php
                        foreach ($categories as $item) {
                            ?>
                            <option value="<?php echo $item->id; ?>"><?php echo $item->treename; ?> </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="row-item col-xs-6">
                    <div class="input-group custom-search-form">
                        <input type="text" placeholder="Tìm kiếm" name='products_related_keyword' class="form-control"
                               value='' id='products_related_keyword'/>
                        <span class="input-group-btn">
							<a id='products_related_search' class="btn btn-default">
								<i class="fa fa-search"></i>
							</a>
						</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class='title-related'>Danh sách sản phẩm</div>
            <div id='products_related_l'>
                <div id='products_related_search_list'></div>
            </div>
        </div>

        <div class="col-xs-12 col-md-6">
            <div id='products_related_r'>
                <!--	LIST RELATE			-->
                <div class='title-related'>Sản phẩm KM</div>
                <ul id='products_sortable_related'>
                    <?php
//                    var_dump($flash_sale);
                    $i = 0;
                    if (@$flash_sale)
                        foreach ($flash_sale as $item) {
                            $model = $this->model;
                            $data_prd_item = $model->get_prd_items($item->product_gift_id);

//                            $discount_value = 0;
//                            if ($data_sale_item->discount_unit == 2) {
//                                $discount_value = $item->price - (100 - $data_sale_item->discount)*$item->price;
//                            }else{
//                                $discount_value = $item->price -  $data_sale_item->discount;
//                            }
                            ?>
                            <li id='products_record_related_<?php echo $item->id ?>'><?php echo $data_prd_item->name; ?>
                                <a class='products_remove_relate_bt'
                                   onclick="javascript: remove_products_related(<?php echo $item->id ?>)"
                                   href="javascript: void(0)" title='Xóa'>
                                    <img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png">
                                </a>
                                <div class="price">
                                    <span>Gốc: <?= format_money_0($data_prd_item->price_old, 'đ', 'Liên hệ') ?></span>
                                    <span>/ Bán: <?= format_money_0($data_prd_item->price, 'đ', 'Liên hệ') ?></span>
                                    <!--                                    <span>/ Quy đổi: -->
                                    <? //=format_money_0($discount_value,'đ','Liên hệ')?><!--</span>-->
                                </div>
                                <div class="top_title"
                                     style=" margin-top: 10px">
                                    <span>Giá quy đổi:</span>
                                </div>
                                <div class="box_val">
                                    <input class="form-control" type="text" value="<?= @$item->price_new ?>"
                                           name="price_new_<?php echo $item->product_gift_id ?>"
                                           id="price_new_<?php echo $item->product_gift_id ?>">
                                </div>
                                <input type="hidden" name='promotion_products[]' value="<?php echo $item->product_gift_id; ?>"/>
                            </li>
                        <?php } ?>
                </ul>
                <!--	end LIST RELATE			-->
                <div id='products_record_related_continue'></div>
            </div>
        </div>
    </div>
</div>
<?php
$this->dt_form_end_col(); // END: col-1
?>
<script type="text/javascript" language="javascript">
    // $(function () {
    //     $("#date_end").datepicker({clickInput: true, dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});
    //     $("#date_end").change(function () {
    //         document.formSearch.submit();
    //     });
    //     $("#date_start").datepicker({clickInput: true, dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});
    //     $("#date_start").change(function () {
    //         document.formSearch.submit();
    //     });
    // });
</script>

<script type="text/javascript">
    //search_products_related();
    // $("#products_sortable_related").sortable();

    function products_add_related() {
        $('#products_related_l').show();
        $('#products_related_l').attr('width', '50%');
        $('#products_related_r').attr('width', '50%');
        $('.products_close_related').show();
        $('.products_add_related').hide();
    }

    function products_close_related() {
        $('#products_related_l').hide();
        $('#products_related_l').attr('width', '0%');
        $('#products_related_r').attr('width', '100%');
        $('.products_add_related').show();
        $('.products_close_related').hide();
    }

    //function search_products_related(){
    $("#products_related_category_id").change(function () {
        var category_id = $('#products_related_category_id').val();
        var product_id = <?php echo @$data->id ? $data->id : 0 ?>;
        var str_exist = '';
        products_related(keyword = null, category_id, product_id, str_exist)
    })
    $('#products_related_search').on('click', function () {
        var keyword = $('#products_related_keyword').val();
        if (keyword == '' || keyword == null) {
            alert('Bạn chưa nhập từ khóa tìm kiếm');
            return
        }
        var category_id = $('#products_related_category_id').val();
        var product_id = <?php echo @$data->id ? $data->id : 0 ?>;
        var str_exist = '';
        products_related(keyword, category_id = null, product_id, str_exist);
    });
    $('#products_related_keyword').on('keyup', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            var keyword = $('#products_related_keyword').val();
            if (keyword == '' || keyword == null) {
                alert('Bạn chưa nhập từ khóa tìm kiếm');
                return
            }
            var category_id = $('#products_related_category_id').val();
            var product_id = <?php echo @$data->id ? $data->id : 0 ?>;
            var str_exist = '';
            products_related(keyword, category_id = null, product_id, str_exist);
        }
    });

    //}
    function products_related(keyword, category_id, product_id, str_exist) {

        $("#products_sortable_related li input").each(function (index) {
            if (str_exist != '')
                str_exist += ',';
            str_exist += $(this).val();
        });
        $.get("index2.php?module=promotion&view=accompanying&task=ajax_get_products_related&raw=1", {
            product_id: product_id,
            keyword: keyword,
            category_id: category_id,
            str_exist: str_exist
        }, function (html) {
            $('#products_related_search_list').html(html);
        });
    }

    function gene_all() {
        var ids = $('#gene_all').val();
        var id = ids.split(',');
        var lenth_arr = id.length;
        for (var i = 0; i < lenth_arr; i++) {
            set_products_related(id[i]);
        }
    }

    function set_products_related(id) {
        // var max_related = 10;
        // var length_children = $("#products_sortable_related li").length;
        // if (length_children >= max_related) {
        //     alert('Tối đa chỉ có ' + max_related + ' sản phẩm liên quan');
        //     return;
        // }


        var title = $('.products_related_item_' + id).html();
        var html = '<li id="products_record_related_' + id + '">' + title + '<input type="hidden" name="promotion_products[]" value="' + id + '" />';
        html += '<a class="products_remove_relate_bt"  onclick="javascript: remove_products_related(' + id + ')" href="javascript: void(0)" title="Xóa"><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a>';
        // html += '<div class="price">';
        //html += '<span>Gốc: <?php //echo format_money_0($item->price_old, 'đ', 'Liên hệ')?>//. </span>';
        //html += '<span> / Bán: <?php //echo format_money_0($item->price, 'đ', 'Liên hệ')?>//</span>';
        // html += '</div>';
        html += '<div class="top_title" style=" margin-top: 10px">';
        html += '<span>Giá quy đổi:</span>';
        html += '</div>';
        html += '<div class="box_val">';
        html += '<input class="form-control" type="text" value="" name="price_new_' + id + '" id="price_new_' + id + '">';
        html += '</div>';
        html += '</li>';
        $('#products_sortable_related').append(html);
        $('.products_related_item_' + id).hide();
    }

    function remove_products_related(id) {
        $('#products_record_related_' + id).remove();
        $('.products_related_item_' + id).show().addClass('red');
    }
</script>
