<?php $this->pageTitle = 'Подробный отчет'; ?>
<div class="content archive">
    <h2 class="big_title">Кто нам помогает</h2>
    <h3 class="gray_title">Пожертвования, сделанные на сайте, моментально отображаются на данной странице. С полной статистикой поступлений можно ознакомиться в нашей группе Вконтакте в разделе "Отчеты".</h3>

    <div class="before_table"></div>

    <table class="table_archive">
        <thead>
            <tr>
                <th>Имя жертвователя</th>
                <th>Имя пациента</th>
                <th>Сумма</th>
                <th>Способ перевода</th>
                <th>Дата</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($models as $model): ?>
                <tr>
                    <td><?php echo $model->from?></td>
                    <td><?php echo $model->item->name?></td>
                    <td><?php echo $model->sum?>Р</td>
                    <?php if ($model->way == 'card-or-yandex'): ?>
                        <td>Яндекс / Карты</td>
                    <?php else: ?>
                        <td><?php echo $model->way?></td>
                    <?php endif ?>
                    <td><?php echo date("d.m.Y",strtotime($model->date))?></td>
                </tr>
            <?php endforeach ?>

        </tbody>
    </table>

    <div class="line">
    </div>

    <!--

    <ul class="archive_list">

        <li>
            <a href="javascript:void(0)" class="">Архив за 2014 год <span class="plus">+</span><span class="minus">-</span></a>

            <ul class="clearfix" style="display: none;">
                <li><a href="#">Январь</a></li>
                <li><a href="#">Февраль</a></li>
                <li><a href="#">Март</a></li>
                <li><a href="#">Апрель</a></li>
                <li><a href="#">Май</a></li>
                <li><a href="#">Июнь</a></li>
                <li><a href="#">Июль</a></li>
                <li><a href="#">Август</a></li>
                <li><a href="#">Сентябрь</a></li>
                <li><a href="#">Октябрь</a></li>
                <li><a href="#">Ноябрь</a></li>
                <li><a href="#">Декабрь</a></li>
            </ul>
        </li>

        <li>
            <a href="javascript:void(0)" class="">Архив за 2014 год <span class="plus">+</span><span class="minus">-</span></a>

            <ul class="clearfix" style="display: none;">
                <li><a href="#">Январь</a></li>
                <li><a href="#">Февраль</a></li>
                <li><a href="#">Март</a></li>
                <li><a href="#">Апрель</a></li>
                <li><a href="#">Май</a></li>
                <li><a href="#">Июнь</a></li>
                <li><a href="#">Июль</a></li>
                <li><a href="#">Август</a></li>
                <li><a href="#">Сентябрь</a></li>
                <li><a href="#">Октябрь</a></li>
                <li><a href="#">Ноябрь</a></li>
                <li><a href="#">Декабрь</a></li>
            </ul>
        </li>

        <li>
            <a href="javascript:void(0)" class="">Архив за 2014 год <span class="plus">+</span><span class="minus">-</span></a>

            <ul class="clearfix" style="display: none;">
                <li><a href="#">Январь</a></li>
                <li><a href="#">Февраль</a></li>
                <li><a href="#">Март</a></li>
                <li><a href="#">Апрель</a></li>
                <li><a href="#">Май</a></li>
                <li><a href="#">Июнь</a></li>
                <li><a href="#">Июль</a></li>
                <li><a href="#">Август</a></li>
                <li><a href="#">Сентябрь</a></li>
                <li><a href="#">Октябрь</a></li>
                <li><a href="#">Ноябрь</a></li>
                <li><a href="#">Декабрь</a></li>
            </ul>
        </li>
    </ul>
    -->
    <div class="thank_you">
        <h3>Огромное </h3>
        <p>спасибо за Вашу помощь!</p>
    </div>
</div>