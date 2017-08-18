<?php
$id = (int) getParam('id');
$user = currentUser();
$userId = $user ? $user['id'] : 0;
$query = DB::prepare('SELECT * FROM posts WHERE user_id=:user_id AND deleted_at IS NULL ORDER BY id DESC');
$query->bindParam('user_id', $userId, PDO::PARAM_INT);
$query->execute();

$posts = $query->fetchAll(PDO::FETCH_ASSOC);

$activePost = Post::findWithUser($id, $userId);
?>
<div class="container">

    <section id="post-index">
        <ul>
        <?php if (!$id) { ?>
            <li class="actived">
                <a href="/">新文档</a>
            </li>
        <?php } ?>
        <?php foreach ($posts as $post) { ?>
            <li<?php echo intval($post['id']) == $id ? ' class="actived"' : '' ?>>
            <a href="<?php echo url(['id'=>$post['id']]) ?>"><?php echo Post::getTitle($post['id']) ?><time><?php echo formatDateToHuman($post['created_at']) ?></time></a>
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
        <form action="<?php echo url($activePost ? 'update' : 'create') ?>" method="post">
            <?php if ($activePost) { ?>
            <input name="id" value="<?php echo (int) $activePost['id'] ?>">
            <?php } ?>
            <textarea name="content"><?php echo $activePost ? $activePost['content'] : '' ?></textarea>
            <footer>
                <button type="submit" class="btn">保存</button>
                <?php if ($activePost) { ?>
                <a href="<?php echo url(['action'=>'destroy', 'id'=>$id]) ?>" class="btn">丢弃</a>
                <?php } ?>
            </footer>
        </form>
    </div>

</div>
