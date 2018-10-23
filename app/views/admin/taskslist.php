<h1>Редактирование заданий курса <br><?=$course['name']?></h1>
<a href="/admin/addtask/<?=$course['id']?>" class="btn">Добавить новое задание</a>
<table>
    <tr>
        <th>Дата и время</th>
        <th>Название</th>
        <th>Описание</th>
        <th>Проверка</th>
        <th>Активное</th>
        <th>% прохождения курса</th>
        <th>Редактировать</th>
        <!-- <th>Удалить</th> -->
    </tr>
    <?php foreach($courseTasks as $courseTask):?>
    <tr>
        <?php if($courseTask['timestart'] == 0):?>
        <td>
            Общее задание
        </td>
        <?php else: ?>
        <td>
            <?=date('d.m.y H:i', $courseTask['timestart'])?>
        </td>
        <?php endif ?>
        <td>
            <?=$courseTask['name']?>
        </td>
        <td>
            <?=$courseTask['description']?>
        </td>
        <td>
            <?=$courseTask['verify']?>
        </td>
        <td>
            <?=$courseTask['active']?>
        </td>
        <td>
            <?=$courseTask['percent']?>
        </td>
        <td>
            <a class="btn btn-sm" href="/admin/edittask/<?=$courseTask['id']?>">Редактировать</a>
        </td>
        <!-- <td>
            <form action="/admin/taskslist/<?=$course['id']?>" method="post">
                <input type="hidden" name="id" value="<?=$courseTask['id']?>">
                <input type="hidden" name="course" value="<?=$course['id']?>">
                <input type="hidden" name="action" value="delete">
                <button type="submit" class="btn btn-sm">Удалить</button>
            </form>
        </td> -->
    </tr>
    <?php endforeach ?>
</table>