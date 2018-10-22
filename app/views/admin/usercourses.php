<h1>Список студентов по курсам</h1>
<button data-type="show" data-action=".newusercourses">Добавить</button>
<div class="newusercourses" style="display: none;">
    <form class="form-inline" action="/admin/usercourses" method="post">
        <div class="control-group form-group">
            <label>Курс:</label>
            <select class="form-control" name="course">
                <?php foreach($coursesList as $coursesListItem):?>
                <?php if($coursesListItem['type'] != 0):?>
                <option value="<?=$coursesListItem['id']?>">
                    <?=$coursesListItem['name']?>
                </option>
                <?php endif?>
                <?php endforeach ?>
            </select>
        </div>
        <div class="control-group form-group">
            <label>Пользователь:</label>
            <select class="form-control" name="user">
                <?php foreach($usersList as $user):?>
                <option value="<?=$user['id']?>">
                    <?=$user['fname'].' '.$user['lname']?>
                </option>
                <?php endforeach ?>
            </select>
        </div>
        <button type="button" class="btn btn-sm" data-type="usercourses" data-action="add">Добавить</button>
    </form>
</div>

<table>
    <tr>
        <th>Курс</th>
        <th>Студент</th>
        <th>Процент прохождения</th>
        <th>Удалить</th>
    </tr>
    <?php foreach($userCoursesList as $userCourses):?>
    <tr>
        <td>
            <?=$userCourses['coursename']?>
        </td>
        <td>
            <?=$userCourses['fname'].' '.$userCourses['lname']?>
        </td>
        <td>
            <?=$userCourses['percent']?>
        </td>
        <td><button class="btn btn-sm" data-type="usercourses" data-action="delete" data-user="<?=$userCourses['userid']?>"
                data-course="<?=$userCourses['courseid']?>">Удалить</button></td>
    </tr>
    <?php endforeach ?>
</table>