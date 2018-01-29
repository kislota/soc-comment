<?php use app\model\User; ?>
<div class="comments_wrap">
    <?php if (User::id()): ?>
        <div class="starter-template">
            <h3>Оставьте ваш комментарий</h3>
            <div class="row">
                <div class="col-xs-3">
                </div>
                <div class="col-xs-6">
                    <form action="/comment/create" method="post">
                        <textarea name="message" class="form-control" rows="3"></textarea>
                        <button type="submit" class="btn btn-primary">Отправить</button>
                    </form>
                </div>
                <div class="col-xs-3">
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if (!User::id()): ?>
        <div class="starter-template">
            <h1>Для входа нажмите на нужную социальную сеть</h1>
            <?php foreach ($socials as $key => $social):?>
                <a href="<?php echo $social; ?>" class="btn btn-primary btn-lg active"
                   role="button"><?php echo ucfirst($key);?></a>
            <?php endforeach;?>
        </div>
    <?php endif; ?>
    <div class='row'>
        <div class='col-md-2'></div>
        <div class='col-md-8'>
        <ul>
            <div id='content'>
                <?php echo $comments; ?>
            </div>
        </ul>
        </div>
        <div class='col-md-2'></div>
    </div>
</div>

<div id='load'>
    <div>Загрузить еще</div>
    <img src='/images/loading.gif' id='imgLoad'>
</div>


<div class='modal fade modal-comment' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'
     aria-hidden='true'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <form action="/comment/create" method="post">
                <div class='modal-header'>
                    <button type='button' onclick="modal_close()" class='close' data-dismiss='modal' aria-label='Close'><span
                                aria-hidden='true'>&times;</span></button>
                    <h4 class='modal-title' id='myModalLabel'>Комментарий</h4>
                </div>
                <div class='modal-body'>
                    <div class='row'>
                        <div class='col-md-12'>
                            <input type='hidden' id='comment_id' name='comment_id'>
                            <input type='hidden' id='parent_id' name='parent_id'>
                            <small>Напишите ваш комментарий</small>
                            <textarea name='message' id='message' class='form-control' rows='3'></textarea>
                        </div>
                    </div>
                </div>
                <div class='modal-footer'>
                    <button type='button' onclick="modal_close()" class='btn btn-default' data-dismiss='modal'>Завкрыть</button>
                    <button type='submit' class='btn btn-primary'>Отправить</button>
                </div>
            </form>
        </div>
    </div>
</div>