<?php
$id = (int) getParam('id');

$db = DB::connect();
$result = $db->query('SELECT * FROM posts WHERE deleted_at IS NULL ORDER BY id DESC');
$notes = $result->fetchAll(PDO::FETCH_ASSOC);

$activeNote = Note::find($id);
?>
<div class="container">

    <section id="note-index">
        <ul>
        <?php if (!$id) { ?>
            <li class="actived">
                <a href="/">新文档</a>
            </li>
        <?php } ?>
        <?php foreach ($notes as $note) { ?>
            <li<?php echo intval($note['id']) == $id ? ' class="actived"' : '' ?>>
            <a href="<?php echo url(['id'=>$note['id']]) ?>"><?php echo Note::getTitle($note['id']) ?><time><?php echo formatDateToHuman($note['created_at']) ?></time></a>
            </li>
        <?php } ?>
        </ul>
        <footer>
            <a href="/">新增笔记</a>
            <?php if (isLogined()) { ?>
            <a href="<?php echo url('logout') ?>">退出</a>
            <?php } else { ?>
            <a href="<?php echo url('login') ?>">登录</a>
            <?php } ?>
        </footer>
    </section>

    <div id="editor-container">
        <form action="<?php echo url($activeNote ? 'update' : 'create') ?>" method="post">
            <?php if ($activeNote) { ?>
            <input name="id" value="<?php echo (int) $activeNote['id'] ?>">
            <?php } ?>
            <textarea name="content"><?php echo $activeNote ? $activeNote['content'] : '' ?></textarea>
            <footer>
                <button type="submit" class="btn">保存</button>
                <?php if ($activeNote) { ?>
                <a href="<?php echo url(['action'=>'destroy', 'id'=>$id]) ?>" class="btn">丢弃</a>
                <?php } ?>
            </footer>
        </form>
    </div>

</div>
