    <h2>Опции</h2>


    <form method='post'>
        <select id='custom-headers' multiple='multiple' name='options[]' class='searchable'>
            <?php
            if (!$model->isNewRecord):
                $alreadyGot = CatItemsToItems::model()->findAll(array('select'=>'toItemId', 'condition' => 'itemId='.$model->id));

                $arrayOfItems = array();
                foreach ($alreadyGot as $item) {
                    array_push($arrayOfItems, $item->toItemId);
                }
                $arrayOfItems = array_filter($arrayOfItems);
                $items = CatItem::model()->findAll(array('order'=>'id ASC'));

                if (is_array($items) && count($items)>0):

                    foreach ($items as $item): ?>

                        <?php $checked = in_array($item->id, $arrayOfItems) ? "selected" : "" ?>

                        <option <?php echo $checked?> value="<?php echo $item->id?>"><?php echo $item->name?>(<?php echo number_format($item->price, 0, ',', ' ');?> руб.)<span class='editItem'></span></option>


                    <?php endforeach;
                endif;
            endif;
            ?>
        </select>
        <script>
            $('.searchable').multiSelect({
                selectableHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='Поиск по опциям...'>",
                selectionHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='Уже в опциях...'>",
                afterInit: function(ms){
                    var that = this,
                        $selectableSearch = that.$selectableUl.prev(),
                        $selectionSearch = that.$selectionUl.prev(),
                        selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
                        selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

                    that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                        .on('keydown', function(e){
                            if (e.which === 40){
                                that.$selectableUl.focus();
                                return false;
                            }
                        });

                    that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                        .on('keydown', function(e){
                            if (e.which == 40){
                                that.$selectionUl.focus();
                                return false;
                            }
                        });
                },
                afterSelect: function(){
                    this.qs1.cache();
                    this.qs2.cache();
                },
                afterDeselect: function(){
                    this.qs1.cache();
                    this.qs2.cache();
                }
            });
        </script>
        <br/>

        

    <?php
    $related = CatItemsToItems::model()->findAll(array('select'=>'itemId', 'condition' => 'toItemId='.$model->id));
    if ((!$model->isNewRecord) && (count($related) > 0)):
        ?>
        <h2>Сопутствует</h2>
        <p>Список других товаров, у которых текущий товар указан как сопутствующий товар или в виде опции.</p>
        <?php

        $arrayOfItems = array();
        foreach ($related as $item) {
            array_push($arrayOfItems, $item->itemId);
        }
        $arrayOfItems = array_filter($arrayOfItems);
        foreach ($items as $item): ?>
            <?php if(in_array($item->id, $arrayOfItems)): ?>
                <div id="<?php echo $item->id;?>" style="float: left; width: 100%;">
                    <a href="/catalog/catItem/update/id/<?php echo $item->id;?>"><?php echo $item->name; ?> </a><a onClick="removeOption('<?php echo $item->id;?>', '<?php echo $model->id;?>');" href="#">Убрать</a>
                </div>
            <?php endif; ?>
        <?php
        endforeach;
        ?>
        <div style="float: left; width: 100%;">
            <br />
        </div>
        <script>
            function removeOption(id, subid){
                $.ajax({
                    url: '/catalog/catItem/options/id/'+id+'/subid/'+subid,
                    success: function(){
                        $('#'+id).remove();
                    }
                });
            }
        </script>
    <?php
    endif;
    ?>


<h2>Добавить как опцию в карочки</h2>

        <select id='custom-headers2' multiple='multiple' name='items[]' class='searchable2'>
            <?php
            if (!$model->isNewRecord):
                $alreadyGot = CatItemsToItems::model()->findAll(array('select'=>'itemId', 'condition' => 'toItemId='.$model->id));

                $arrayOfItems = array();
                foreach ($alreadyGot as $item) {
                    array_push($arrayOfItems, $item->itemId);
                }
                $arrayOfItems = array_filter($arrayOfItems);
                $items = CatItem::model()->findAll(array('order'=>'id ASC'));

                if (is_array($items) && count($items)>0):

                    foreach ($items as $item): ?>

                        <?php $checked = in_array($item->id, $arrayOfItems) ? "selected" : "" ?>

                        <option <?php echo $checked?> value="<?php echo $item->id?>"><?php echo $item->name?>(<?php echo number_format($item->price, 0, ',', ' ');?> руб.)<span class='editItem'></span></option>


                    <?php endforeach;
                endif;
            endif;
            ?>
        </select>
        <script>
            $('.searchable2').multiSelect({
                selectableHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='Поиск по опциям...'>",
                selectionHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='Уже в опциях...'>",
                afterInit: function(ms){
                    var that = this,
                        $selectableSearch = that.$selectableUl.prev(),
                        $selectionSearch = that.$selectionUl.prev(),
                        selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
                        selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

                    that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                        .on('keydown', function(e){
                            if (e.which === 40){
                                that.$selectableUl.focus();
                                return false;
                            }
                        });

                    that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                        .on('keydown', function(e){
                            if (e.which == 40){
                                that.$selectionUl.focus();
                                return false;
                            }
                        });
                },
                afterSelect: function(){
                    this.qs1.cache();
                    this.qs2.cache();
                },
                afterDeselect: function(){
                    this.qs1.cache();
                    this.qs2.cache();
                }
            });
        </script>
        <br/>

        <input type="submit" name='saveItemsToItems' class='btn btn-primary' value='сохранить'/>
    </form>

    <?php
    $related = CatItemsToItems::model()->findAll(array('select'=>'itemId', 'condition' => 'itemId='.$model->id));
    if ((!$model->isNewRecord) && $related):
        ?>
        <h2>Уже в опция у данных карточек</h2>
        <?php

        $arrayOfItems = array();
        foreach ($related as $item) {
            array_push($arrayOfItems, $item->itemId);
        }
        $arrayOfItems = array_filter($arrayOfItems);
        foreach ($items as $item): ?>
            <?php if(in_array($item->id, $arrayOfItems)): ?>
                <div id="<?php echo $item->id;?>" style="float: left; width: 100%;">
                    <a href="/catalog/catItem/update/id/<?php echo $item->id;?>"><?php echo $item->name; ?> </a><a onClick="removeOption('<?php echo $item->id;?>', '<?php echo $model->id;?>');" href="#">Убрать</a>
                </div>
            <?php endif; ?>
        <?php
        endforeach;
        ?>
        <div style="float: left; width: 100%;">
            <br />
        </div>
        <script>
            function removeOption(id, subid){
                $.ajax({
                    url: '/catalog/catItem/options/id/'+id+'/subid/'+subid,
                    success: function(){
                        $('#'+id).remove();
                    }
                });
            }
        </script>
    <?php
    endif;
    ?>