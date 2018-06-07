<div class="modal fade" id="modal_banner">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="modal_title_banner">Новый баннер</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger hidden modal-banner-error">
                    &nbsp;
                </div>
                <form action="<?php echo $host; ?>adminpanel/ajax" method="POST" enctype="multipart/form-data" id="modal_banner_form">
                    <div class="form-group">
                        <input type="text" class="form-control" name="modal_banner_name" id="modal_banner_name" placeholder="Название" maxlength="50" />
                    </div>
                    <div class="form-group">
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 modal-banner-url-left">
                            <select class="form-control" name="modal_banner_url_protocol" id="modal_banner_url_protocol">
                                <option value="http">http://</option>
                                <option value="https">https://</option>
                            </select>
                        </div>
                        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 modal-banner-url-right">
                            <input type="text" class="form-control" name="modal_banner_url_link" id="modal_banner_url_link" placeholder="URL" />
                        </div>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="modal_banner_status" id="modal_banner_status">
                            <option value="off">Баннер отключен</option>
                            <option value="on">Баннер включен</option>
                        </select>
                    </div>
                    <p>
                        Рекомендуемый размер изображения 300x250 (jpg, png, gif):
                    </p>
                    <div class="form-group" id="modal_banner_note">
                        <div class="hidden" style="margin-bottom: 15px;">Оставьте поле пустым если не собираетесь менять текущую картинку</div>
                        <input type="file" name="modal_banner_file" id="modal_banner_file">
                    </div>
                    <input type="hidden" name="modal_banner_mode" id="modal_banner_mode" value="new" />
                    <input type="hidden" name="modal_banner_id" id="modal_banner_id" value="" />
                    <input type="hidden" name="modal_banner_file_current" id="modal_banner_file_current" value="" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" id="modal_banner_submit">Добавить</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="modal_delete_banner">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">&nbsp;</h4>
            </div>
            <div class="modal-body">
                <p>Вы действительно хотите удалить баннер "<span id="modal_delete_banner_name"></span>"?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-danger" id="modal_delete_banner_submit" onclick="">Да</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 banners-top-panel">
    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
        Всего баннеров: <?= $data['count_banners']; ?>
    </div>
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-right">
        <button class="btn btn-success" onclick="banner_new();">Добавить баннер&nbsp;&nbsp;<span class="glyphicon glyphicon-plus"></span></button>
    </div>
</div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding:0;">
    <?php
        if($data['count_banners'] == "0"){
            ?>
                <div style="color: #474747;font-size: 18px;" class="text-center">
                    - Не найдено ни одного баннера -
                </div>
            <?php
        }
        else{
            function button_position_up($position){
                if($position == 0 or $position == 1){
                    echo " disabled";
                }
            }
            function button_position_down($position, $count_status_on){
                if($position == 0 or $position == $count_status_on){
                    echo " disabled";
                }
            }
            foreach($data['banners'] as $banner){
                ?>
                    <div class="adminpanel-banner">
                        <div class="adminpanel-banner-buttons">
                            <button class="btn btn-info btn-xs" onclick="banner_edit(<?= $banner['id']; ?>);">Редактировать <span class="glyphicon glyphicon-pencil"></span></button>
                            <button class="btn btn-danger btn-xs" onclick="modal_banner_delete(<?= $banner['id']; ?>);">Удалить <span class="glyphicon glyphicon-trash"></span></button>
                        </div>
                        <div class="adminpanel-banner-img">
                            <div><img src="/<?= $banner['banner_img']; ?>" /></div>
                        </div>
                        <div class="adminpanel-banner-name adminpanel-banner-name-limit" onMouseOver="$('.adminpanel-banner-name').removeClass('adminpanel-banner-name-limit');" onMouseOut="$('.adminpanel-banner-name').addClass('adminpanel-banner-name-limit');"><?= $banner['banner_name']; ?></div>
                        <div style="padding: 2px;">&nbsp;</div>
                        <div class="adminpanel-banner-url"><a href="<?= $banner['banner_url_protocol'] . "://" . $banner['banner_url_link']; ?>" target="_blank"><?= $banner['banner_url_protocol'] . "://" . $banner['banner_url_link']; ?></a></div>
                        <div class="adminpanel-banner-status">-  
                            <?php
                                if($banner['banner_status'] == "on"){
                                    echo "Баннер включен";
                                }
                                elseif($banner['banner_status'] == "off"){
                                    echo "Баннер отключен";
                                }
                            ?> -
                        </div>
                        <div class="adminpanel-banner-position">
                            Позиция: #<?= $banner['banner_position']; ?>
                        </div>
                        <div class="adminpanel-banner-position-button">
                            <button class="btn<?php button_position_up($banner['banner_position']); ?>" onclick="banner_position_change(<?= $banner['banner_position']; ?>, 'up');"><span class="glyphicon glyphicon-chevron-up"></span></button>
                            <button class="btn<?php button_position_down($banner['banner_position'], $data['count_status_on']); ?>" onclick="banner_position_change(<?= $banner['banner_position']; ?>, 'down');"><span class="glyphicon glyphicon-chevron-down"></span></button>
                        </div>
                    </div>
                <?php
            }
        }
    ?>
</div>
<div class="col-xs-12 text-center">
    <?php 	
        $data['pagination']->start();
        echo "\n";
    ?>
</div>