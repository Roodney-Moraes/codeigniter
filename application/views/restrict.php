<section class="light-bg login">
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
                    <a id="btn_your_user" class="btn btn-link" user_id="<?=$user_id?>"><i class="fa fa-user"></i></a>
                    <a href="restrict/logout" class="btn btn-link"><i class="fa fa-sign-out"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_movies" role="tab" data-toggle="tab">Filmes</a></li>
            <li><a href="#tab_team" role="tab" data-toggle="tab">Equipe</a></li>
            <li><a href="#tab_user" role="tab" data-toggle="tab">Usuários</a></li>
        </ul>

        <div class="tab-content">
            <div id="tab_movies" class="tab-pane active">
                <div class="container-fluid">
                    <h2 class="text-center"><strong>Gerenciar Filmes</strong></h2>
                    <a id="btn_add_movie" class="btn btn-primary"><i class="fa fa-plus">&nbsp;&nbsp;Adicionar Filme</i></a>
                    <table id="dt_movies" class="table table-striped table-bordered">
                        <thead>
                            <tr class="tableheader">
                                <th>Nome</th>
                                <th>Imagem</th>
                                <th>Duração</th>
                                <th>Descrição</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table> 
                </div>
            </div>
            <div id="tab_team" class="tab-pane">
                <div class="container-fluid">
                    <h2 class="text-center"><strong>Gerenciar Equipe</strong></h2>
                    <a id="btn_add_member" class="btn btn-primary"><i class="fa fa-plus">&nbsp;&nbsp;Adicionar Mebro</i></a>
                    <table id="dt_team" class="table table-striped table-bordered">
                        <thead>
                            <tr class="tableheader">
                                <th>Nome</th>
                                <th>Foto</th>
                                <th>Descrição</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table> 
                </div>
            </div>
            <div id="tab_user" class="tab-pane">
                <div class="container-fluid">
                    <h2 class="text-center"><strong>Gerenciar Usuários</strong></h2>
                    <a id="btn_add_user" class="btn btn-primary"><i class="fa fa-plus">&nbsp;&nbsp;Adicionar Usuário</i></a>
                    <table id="dt_users" class="table table-striped table-bordered">
                        <thead>
                            <tr class="tableheader">
                                <th>login</th>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Ações</th>
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

<!-- MODAL FILMES -->
<div id="modal_movie" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">x</button>
                <h4 class="modal-title">Filmes</h4>
            </div>
            <div class="modal-body">
            <form id="form_movie">
                <input type="hidden" id="movie_id" name="movie_id">

                <div class="form-group">
                    <label class="col-lg-2 control-label">Nome</label>
                    <div class="col-lg-10">
                        <input type="text" id="movie_name" class="form-control" name="movie_name" maxlength="100">
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-2 control-label">Imagem</label>
                    <div class="col-lg-10">
                        <img src="" id="movie_img_path" class="img_size">
                        <label class="btn btn-block btn-info">
                            <i class="fa fa-upload">&nbsp;&nbsp;Importar imagem</i>
                            <input type="file" accept="image/*" id="btn_upload_movie_img" class="form-control esconder">
                        </label>
                        <input type="hidden" id="movie_img" name="movie_img">
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-2 control-label">Duração (h)</label>
                    <div class="col-lg-10">
                        <input type="number" id="movie_duration" step="0.1" class="form-control" name="movie_duration">
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-2 control-label">Descrição</label>
                    <div class="col-lg-10">
                        <textarea name="movie_description" id="movie_description" class="form-control"></textarea>
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group text-center">
                   <button type="submit" id="btn_save_movie" class="btn btn-primary">
                        <i class="fa fa-save">&nbsp;&nbsp;Salvar</i>
                   </button>
                   <span class="help-block"></span>
                </div>

            </form>
            </div>
        </div>
    </div>
</div>


<!-- MODAL EQUIPE -->
<div id="modal_member" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">x</button>
                <h4 class="modal-title">Membro</h4>
            </div>
            <div class="modal-body">
            <form id="form_member">
                <input type="hidden" id="member_id" name="member_id">

                <div class="form-group">
                    <label class="col-lg-2 control-label">Nome</label>
                    <div class="col-lg-10">
                        <input type="text" id="member_name" class="form-control" name="member_name" maxlength="100">
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-2 control-label">Foto</label>
                    <div class="col-lg-10">
                        <img src="" id="member_photo_path" class="img_size">
                        <label class="btn btn-block btn-info">
                            <i class="fa fa-upload">&nbsp;&nbsp;Importar foto</i>
                            <input type="file" accept="image/*" id="btn_upload_member_photo" class="form-control esconder">
                        </label>
                        <input type="hidden" id="member_photo" name="member_photo">
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-2 control-label">Descrição</label>
                    <div class="col-lg-10">
                        <textarea name="member_description" id="member_description" class="form-control"></textarea>
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group text-center">
                   <button type="submit" id="btn_save_member" class="btn btn-primary">
                        <i class="fa fa-save">&nbsp;&nbsp;Salvar</i>
                   </button>
                   <span class="help-block"></span>
                </div>

            </form>
            </div>
        </div>
    </div>
</div>


<!-- MODAL USUÁRIO -->
<div id="modal_user" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">x</button>
                <h4 class="modal-title">Usuário</h4>
            </div>
            <div class="modal-body">
            <form id="form_user">
                <input type="hidden" id="user_id" name="user_id">
                
                <div class="form-group">
                    <label class="col-lg-2 control-label">Login</label>
                    <div class="col-lg-10">
                        <input type="text" id="user_login" class="form-control" name="user_login" maxlength="30">
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-2 control-label">Nome Completo</label>
                    <div class="col-lg-10">
                        <input type="text" id="user_full_name" class="form-control" name="user_full_name" maxlength="100">
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-2 control-label">E-mail</label>
                    <div class="col-lg-10">
                        <input type="email" id="user_email" class="form-control" name="user_email" maxlength="100">
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-2 control-label">Confirmar E-mail</label>
                    <div class="col-lg-10">
                        <input type="email" id="user_email_confirm" class="form-control" name="user_email_confirm" maxlength="100">
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-2 control-label">Senha</label>
                    <div class="col-lg-10">
                        <input type="password" id="user_password" class="form-control" name="user_password">
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-2 control-label">Confirmar Senha</label>
                    <div class="col-lg-10">
                        <input type="password" id="user_password_confirm" class="form-control" name="user_password_confirm">
                        <span class="help-block"></span>
                    </div>
                </div>

                <div class="form-group text-center">
                   <button type="submit" id="btn_save_user" class="btn btn-primary">
                        <i class="fa fa-save">&nbsp;&nbsp;Salvar</i>
                   </button>
                   <span class="help-block"></span>
                </div>

            </form>
            </div>
        </div>
    </div>
</div>

