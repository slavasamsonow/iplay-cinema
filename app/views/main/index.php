<button data-action="modal" data-modal="register">Записаться</button>
<div class="modal register">
    <button type="button" class="close">&times;</button>
    <div class="modal-header">
        Записаться
    </div>
    <div class="modal-body">
        <form action="/" method="post">
            <input type="hidden" name="form" value="register">
            <div class="form-group" data-name="ФИО">
                <input type="text" class="form-control" name="fio" required="required">
            </div>
            <div class="form-group" data-name="email">
                <input type="email" class="form-control" name="email" required='required'>
            </div>
            <div class="form-group" data-name="Телефон">
                <input type="tel" class="form-control" name="phone" required='required'>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="confident" value="confident" checked required> Согласен с <a href="/public/docs/protect_policy_of_personal_information.pdf" target="_blank">Политикой конфеденциальности</a>
                </label>
            </div>
            <input type="submit" class="btn btn-default" value="Записаться">
        </form>
    </div>
</div>