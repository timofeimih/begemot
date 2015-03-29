<?php
$this->menu = array(
    array('label' => 'Все задания', 'url' => array('/jobs/default/index')),
    array('label' => 'Все работы', 'url' => array('/jobs/default/jobs')),
);
?>


<h1>Все работы</h1>

<div class="success" style='color: green'></div>
<table>
    <thead>
    <tr>
        <td>Название файла</td>
        <td>Действия</td>
    </tr>
    </thead>
    <tbody>

    <?php $number = 0; ?>
    <?php foreach($itemList as $item): ?>
        <tr class='item-<?php echo $number ?>'>
            <?php $itemName = new $item; ?>
            <td><?php  echo $itemName->getName();?></td>
            <td>
                <input type="button"
                       class='btn btn-info run'
                       data-name='<?php echo $item?>'
                       value='Запустить'>
                <input type="button"
                       class='btn btn-primary setTask'
                       data-name='<?php echo $item?>'
                       data-turn='0'
                       value='Запланировать'>

                <?php if ($jobManager->isTaskSettedUp($item) == true): ?>
                    (уже установлено хотя бы одно задание)
                <?php endif ?>



                <div class='additionalFields' style='display: none;'><?php $item = new $item; echo $item->getHtmlOfParameters(); ?></div>
            </td>
        </tr>
        <?php $number++; ?>
    <?php endforeach ?>

    </tbody>
</table>



<div class="modal fade" style='display:none'>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Установить задачу (<span class='name'></span>)</h4>
            </div>
            <form action="/jobs/default/setTask" method='post' class='ajaxSubmit' data-hideafter='.modal' data-removeafter=''>
                <div class="modal-body">

                    Временой период: <select name="time">
                        <option value="604800">Раз в неделю в понедельник</option>
                        <option value="302400">Два раза в неделю(в понедельник и четверг)</option>
                        <option value="86400">Ежедневно</option>
                    </select><br/>
                    Точное время выполнения: <select name="hour">
                        <option value='3600'>1</option>
                        <option value='7200'>2</option>
                        <option value='10800'>3</option>
                        <option value='14400'>4</option>
                        <option value='18000'>5</option>
                        <option value='21600'>6</option>
                        <option value='25200'>7</option>
                        <option value='28800'>8</option>
                        <option value='32400'>9</option>
                        <option value='36000'>10</option>
                        <option value='39600'>11</option>
                        <option value='43200'>12</option>
                        <option value='46800'>13</option>
                        <option value='50400'>14</option>
                        <option value='54000'>15</option>
                        <option value='57600'>16</option>
                        <option value='61200'>17</option>
                        <option value='64800'>18</option>
                        <option value='68400'>19</option>
                        <option value='72000'>20</option>
                        <option value='75600'>21</option>
                        <option value='79200'>22</option>
                        <option value='82800'>23</option>
                    </select> час 

                    <select name="minutes">
                        <option value='0'>0</option>
                        <option value='300'>5</option>
                        <option value='600'>10</option>
                        <option value='900'>15</option>
                        <option value='1200'>20</option>
                        <option value='1500'>25</option>
                        <option value='1800'>30</option>
                        <option value='2100'>35</option>
                        <option value='2400'>40</option>
                        <option value='2700'>45</option>
                        <option value='3000'>50</option>
                        <option value='3300'>55</option>
                    </select> минут<br/>
                    <input type="hidden" name='filename' class='filename'/>
                    <input type="hidden" class='listname'/>

                    <div class='additional'></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default closeModal" data-dismiss="modal">Закрыть</button>
                    <button type='submit' name='createNew' class='syncCard btn btn-primary' type='submit'>Сохранить</button>


                </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    $(document).on("click", ".removeTask", function(){
        var button = $(this);
        var params = {'name': $(this).attr("data-name")};


        $.post('/jobs/default/removeTask/', params,  function(data){
            $(button).parents("TR").find(".setTask").show();
            $(button).parents("TR").find(".removeTask").hide();

        }).fail(function(){
            alert("Не вышло");
        });

    })

    $(document).on("click", ".run", function(){
        var button = $(this);
        var params = {'name': $(this).attr("data-name")};


        $.post('/jobs/default/runJob/', params,  function(data){
            $(".success").html("Задача запустилась").fadeIn();

            setTimeout(function(){$(".success").fadeOut()}, 1000);
        }).fail(function(){
            alert("Не вышло");
        });

    })


    $(document).on("click", ".closeModal", function(e){
        $(".modal").removeClass('in').hide();
    })

    $(".close").click(function(){
        $(".modal").removeClass("in").addClass("out");
    })

    $(document).on("click", ".setTask", function(){
        var button = $(this);

        $(".modal").show().addClass("in");
        $(".modal .filename").val($(this).attr("data-name"));
        $(".modal .name").html($(this).attr("data-name"));
        $(".modal .listname").val($(this).parents("TR").attr("class"));
        $(".modal .additional").html($(this).parents("TR").find(".additionalFields").html());

    })

    $(document).on("submit", ".ajaxSubmit", function(e){
        e.preventDefault();
        var form = $(this);
        var hideAfter = $(this).attr("data-hideafter");
        var removeAfter = $(this).attr("data-removeAfter");
        var status = true;
        $(this).find(".required").removeClass("form_error");

        $(this).find(".required").each(function(){
            if ($(this).val() == "") {status = false}
            $(this).addClass("form_error");
        })
        if (!status) return false;

        $.post(form.attr("action"), form.serialize(), function(data){

            $(removeAfter).fadeOut(1000);
            setTimeout(function(){
                $(removeAfter).remove();
                $(hideAfter).removeClass('in').hide();
            }, 1000)

            $(form).find("#success").html("Сохранено");

            $("." + $(form).find(".listname").val()).find(".setTask").hide();

            $("." + $(form).find(".listname").val()).find(".removeTask").show();
        }).fail(function(){
            alert("Не вышло");
        });
    })
</script>
