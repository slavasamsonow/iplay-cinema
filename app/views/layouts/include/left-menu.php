<ul>
    <li class="parent"><span>Проекты</span>
        <ul>
            <li><a href="/projects">Список всех проектов</a></li>
        </ul>
    </li>
    <li class="parent"><span>Курсы</span>
        <ul>
            <li><a href="/account">Активные</a></li>
            <li><a href="/courses">Все курсы</a></li>
        </ul>
    </li>
    <li>
        <a href="/users">Участники</a>
    </li>

    <?php if($_SESSION['user']['role'] == 'admin'):?>
    <li class="parent"><span>Админ</span>
        <ul>
            <li class="parent"><span>Проекты</span>
                <ul>
                    <li><a href="/admin/projects">Список всех проектов</a></li>
                </ul>
            </li>
            <li class="parent"><span>Курсы</span>
                <ul>
                    <li><a href="/admin/confirmtasks">Проверка заданий</a></li>
                    <li><a href="/admin/courses">Список всех курсов</a></li>
                    <li><a href="/admin/usercourses">Ученики в курсах</a></li>
                </ul>
            </li>
            <li class="parent"><span>Новости</span>
                <ul>
                    <li><a href="/admin/newslist">Список всех новостей</a></li>
                </ul>
            </li>
        </ul>
    </li>
    <?php endif ?>
</ul>