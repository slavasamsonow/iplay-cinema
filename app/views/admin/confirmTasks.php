<div class="container-fluid">
    <h1>Подтверждение выполнения заданий</h1>
    Список заданий:
    <?php if(!empty($tasks)): ?>
    <table>
        <tr>
            <th>Курс</th>
            <th>Пользователь</th>
            <th>Задание</th>
            <th>Пояснение</th>
            <th>Подтвердить</th>
        </tr>
        <?php foreach($tasks as $task):?>
        <tr data-task="<?=$task['id']?>">
            <td>
                <?=$task['course_name']?>
            </td>
            <td>
                <?=$task['user_fname'].' '.$task['user_lname']?>
            </td>
            <td>
                <?=$task['title']?>
            </td>
            <td>
                <textarea data-task="<?=$task['id']?>"><?=$task['description']?></textarea>
            </td>
            <td>
                <button class="btn btn-success btn-sm" data-action="confimTask" data-status="done" data-id="<?=$task['id']?>">Подтвердить</button>
                <button class="btn btn-danger btn-sm" data-action="confimTask" data-status="ndone" data-id="<?=$task['id']?>">Не подтверждать</button>
            </td>
        </tr>
        <? endforeach?>
    </table>
    <? else:?>
    Заданий на проверку нет
    <? endif ?>
</div>