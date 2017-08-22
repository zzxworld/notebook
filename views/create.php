<?php
$user = currentUser();
if (!$user) {
    flashMessage('请先登录');
    redirect(url('login'));
}

if (isJsonRequest()) {
    $content = json_decode(file_get_contents('php://input'), true);
    $content = trim(findArray($content, 'content', ''));
} else {
    $content = getParam('content');
}

if (!$content) {
    if (isJsonRequest()) {
        renderJson([
            'error' => 1
        ]);
    } else {
        redirect(url());
    }
}

$content = htmlentities($content);
$time = date('Y-m-d H:i:s');

$query = DB::prepare('INSERT INTO posts(user_id, created_at) VALUES(:user_id, :time)');
$query->bindParam(':user_id', $user['id'], PDO::PARAM_INT);
$query->bindParam(':time', $time);
$query->execute();

$postId = (int) DB::lastInsertId();
if (!$postId) {
    # Rollback
}

if ($content) {
    $query = DB::prepare('INSERT INTO post_versions(post_id, created_at) VALUES(:post_id, :time)');
    $query->bindParam(':post_id', $postId);
    $query->bindParam(':time', $time);
    $query->execute();
    $versionId = (int) DB::lastInsertId();
    if (!$versionId) {
        # Rollback
    }

    $total = mb_strlen($content);
    $offset = 0;
    $limit = Config::get('note_fragment_limit', 500);

    do {
        $fragment = mb_substr($content, $offset, $limit);
        $query = DB::prepare('INSERT INTO post_contents(post_id, version_id, fragment) VALUES(:post_id, :version_id, :fragment)');
        $query->bindParam(':post_id', $postId);
        $query->bindParam(':version_id', $versionId);
        $query->bindParam(':fragment', $fragment);
        $query->execute();

        $offset += $limit;
    } while ($offset < $total);
}

if (isJsonRequest()) {
    renderJson([
        'error' => 0,
        'id' => $postId
    ]);
} else {
    redirect('/?id='.$postId);
}
