<?php
$id = (int) getParam('id');

$time = date('Y-m-d H:i:s');
$query = DB::prepare('UPDATE posts SET deleted_at=:time WHERE id=:id');
$query->bindParam(':time', $time);
$query->bindParam(':id', $id, PDO::PARAM_INT);
$query->execute();

redirect('/');
