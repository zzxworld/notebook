<?php
$id = (int) getParam('id');

$query = DB::prepare('SELECT COUNT(id) as total FROM posts WHERE id=?');
$query->execute([$id]);
$exist = (bool) $query->fetch(PDO::FETCH_ASSOC)['total'];
if (!$exist) {
    redirect('/');
}

$content = htmlentities(getParam('content'));
$time = date('Y-m-d H:i:s');

$query = DB::prepare('UPDATE posts SET updated_at=:time WHERE id=:id');
$query->bindParam(':time', $time);
$query->bindParam(':id', $id, PDO::PARAM_INT);
$query->execute();

$query = DB::prepare('INSERT INTO post_versions(post_id, created_at) VALUES(:post_id, :time)');
$query->bindParam(':post_id', $id, PDO::PARAM_INT);
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
    $query->bindParam(':post_id', $id, PDO::PARAM_INT);
    $query->bindParam(':version_id', $versionId, PDO::PARAM_INT);
    $query->bindParam(':fragment', $fragment);
    $query->execute();

    $offset += $limit;
} while ($offset < $total);

redirect('/?id='.$id);
