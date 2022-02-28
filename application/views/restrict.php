<section style="min-height: calc(100vh - 83px);" class="light-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-offset-3 col-lg-6 text-center">
                <div class="section-title">
                    <h2>ÁREA RESTRITA</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-offset-5 col-lg-2 text-center">
                <div class="form-group">
                    <a id="btn_your_user" class="btn btn-link" userID="<?=$userID?>"><i class="fa fa-user"></i></a>
                    <a class="btn btn-link" href="restrict/logoff"><i class="fa fa-sign-out"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">

        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab_courses" role="tab" data-toggle="tab">Cursos</a>
            </li>
            <li>
                <a href="#tab_team" role="tab" data-toggle="tab">Equipe</a>
            </li>
            <li>
                <a href="#tab_user" role="tab" data-toggle="tab">Usuários</a>
            </li>
        </ul>

        <div class="tab-content">
            <div id="tab_courses" class="tab-pane active">
                <div class="container-fluid">
                    <h2 class="text-center">
                        <strong>Gerenciar Cursos</strong>
                    </h2>
                    <a id="btn_add_course" class="btn btn-primary">
                        <i class="fa fa-plus">&nbsp;&nbsp;Adicionar Curso</i>
                    </a><br/><br/>
                    <table id="dt_courses" class="table table-striped table-bordered">
                        <thead>
                            <tr class="tableheader">
                                <th class="dt-center">Nome</th>
                                <th class="dt-center no-sort">Imagem</th>
                                <th class="dt-center">Duração</th>
                                <th class="no-sort">Descrição</th>
                                <th class="dt-center no-sort">Ações</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>

            <div id="tab_team" class="tab-pane">
                <div class="container-fluid">
                    <h2 class="text-center">
                        <strong>Gerenciar Equipe</strong>
                    </h2>
                    <a id="btn_add_member" class="btn btn-primary">
                        <i class="fa fa-plus">&nbsp;&nbsp;Adicionar Membro</i>
                    </a><br/><br/>
                    <table id="dt_team" class="table table-striped table-bordered">
                        <thead>
                            <tr class="tableheader">
                                <th class="dt-center">Nome</th>
                                <th class="dt-center no-sort">Foto</th>
                                <th class="no-sort">Descrição</th>
                                <th class="dt-center no-sort">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="tab_user" class="tab-pane">
                <div class="container-fluid">
                    <h2 class="text-center">
                        <strong>Gerenciar Usuários</strong>
                    </h2>
                    <a id="btn_add_user" class="btn btn-primary">
                        <i class="fa fa-plus">&nbsp;&nbsp;Adicionar Usuário</i>
                    </a><br/><br/>
                    <table id="dt_users" class="table table-striped table-bordered">
                        <thead>
                            <tr class="tableheader">
                                <th class="dt-center">Login</th>
                                <th class="dt-center">Nome</th>
                                <th class="dt-center">E-mail</th>
                                <th class="dt-center no-sort">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</section>

<div id="modal_course" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">x</button>
                <h4 class="modal-title">Cursos</h4>
            </div>

            <div class="modal-body">
                <form id="form_course">

                    <input id="courseID" name="courseID" hidden>

                    <div class="form-group">
                        <label for="courseName" class="col-lg-2 control-label">Nome</label>
                        <div class="col-lg-10">
                            <input id="courseName" name="courseName" class="form-control" maxlength="100">
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="courseImg" class="col-lg-2 control-label">Imagem</label>
                        <div class="col-lg-10">
                            <img src="" id="course_img_path" style="max-height: 400px; max-width: 400px;"/>
                            <label class="btn btn-block btn-info">
                                <i class="fa fa-upload"></i>&nbsp;&nbsp;Importar Imagem
                                <input type="file" id="btn_upload_course_img" accept="image/*" style="display: none;">
                            </label>
                            <input id="courseImg" name="courseImg" hidden>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="courseDuration" class="col-lg-2 control-label">Duração (h)</label>
                        <div class="col-lg-10">
                            <input type="number" step="0.1" id="courseDuration" name="courseDuration" class="form-control">
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="courseDescription" class="col-lg-2 control-label">Descrição</label>
                        <div class="col-lg-10">
                            <textarea id="courseDescription" name="courseDescription" class="form-control"></textarea>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" id="btn_save_course" class="btn btn-primary">
                            <i class="fa fa-save"></i>&nbsp;&nbsp;Salvar
                        </button>
                        <span class="help-block"></span>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div id="modal_member" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">x</button>
                <h4 class="modal-title">Membro</h4>
            </div>

            <div class="modal-body">
                <form id="form_member">

                    <input id="memberID" name="memberID" hidden>

                    <div class="form-group">
                        <label for="memberName" class="col-lg-2 control-label">Nome</label>
                        <div class="col-lg-10">
                            <input id="memberName" name="memberName" class="form-control" maxlength="100">
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="memberPhoto" class="col-lg-2 control-label">Foto</label>
                        <div class="col-lg-10">
                            <img src="" id="member_photo_path" style="max-height: 400px; max-width: 400px;"/>
                            <label class="btn btn-block btn-info">
                                <i class="fa fa-upload"></i>&nbsp;&nbsp;Importar Foto
                                <input type="file" id="btn_upload_member_photo" accept="image/*" style="display: none;">
                            </label>
                            <input id="memberPhoto" name="memberPhoto" hidden>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="memberDescription" class="col-lg-2 control-label">Descrição</label>
                        <div class="col-lg-10">
                            <textarea id="memberDescription" name="memberDescription" class="form-control"></textarea>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" id="btn_save_member" class="btn btn-primary">
                            <i class="fa fa-save"></i>&nbsp;&nbsp;Salvar
                        </button>
                        <span class="help-block"></span>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div id="modal_user" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">x</button>
                <h4 class="modal-title">Usuário</h4>
            </div>

            <div class="modal-body">
                <form id="form_user">

                    <input id="userID" name="userID" hidden>

                    <div class="form-group">
                        <label for="userLogin" class="col-lg-2 control-label">Login</label>
                        <div class="col-lg-10">
                            <input id="userLogin" name="userLogin" class="form-control" maxlength="30">
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="userFullName" class="col-lg-2 control-label">Nome</label>
                        <div class="col-lg-10">
                            <input id="userFullName" name="userFullName" class="form-control" maxlength="100">
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="userEmail" class="col-lg-2 control-label">E-mail</label>
                        <div class="col-lg-10">
                            <input id="userEmail" name="userEmail" class="form-control" maxlength="100">
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="user_email_confirm" class="col-lg-2 control-label">Confirmar E-mail</label>
                        <div class="col-lg-10">
                            <input id="user_email_confirm" name="user_email_confirm" class="form-control" maxlength="100">
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="userPassword" class="col-lg-2 control-label">Senha</label>
                        <div class="col-lg-10">
                            <input type="password" id="userPassword" name="userPassword" class="form-control">
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="user_password_confirm" class="col-lg-2 control-label">Confirmar Senha</label>
                        <div class="col-lg-10">
                            <input type="password" id="user_password_confirm" name="user_password_confirm" class="form-control">
                            <span class="help-block"></span>
                        </div>
                    </div>


                    <div class="form-group text-center">
                        <button type="submit" id="btn_save_user" class="btn btn-primary">
                            <i class="fa fa-save"></i>&nbsp;&nbsp;Salvar
                        </button>
                        <span class="help-block"></span>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>