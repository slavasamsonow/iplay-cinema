<div class="container-fluid">
    <h1>Создать пользователя</h1>
    <div class="row">
        <div class="col-lg-3">
            <form action="/admin/createuser" method="post">
                <div class="row">
                    <div class="control-group form-group col-md-6">
                        <label>Имя:</label>
                        <input type="text" class="form-control" name="fname" required="true">
                    </div>
                    <div class="control-group form-group col-md-6">
                        <label>Фамилия:</label>
                        <input type="text" class="form-control" name="lname" required="true">
                    </div>
                </div>

                <div class="control-group form-group">
                    <label>E-mail:</label>
                    <input type="email" class="form-control" name="email" required="true">
                </div>
                <div class="control-group form-group">
                    <label>Телефон:</label>
                    <input type="tel" class="form-control" name="phone">
                </div>
                <div class="control-group form-group">
                    <label>Город:</label>
                    <input type="text" class="form-control" name="city">
                </div>
                <button type="submit" class="btn btn-default">Создать</button>
            </form>
        </div>
    </div>

</div>